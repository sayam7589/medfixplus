<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('token')) {
            return redirect()->route('dashboard');
        }else{
            return view('auth.login');
        }
    }
    public function login(Request $request)
    {
        // if (session()->has('token')) {
        //     return redirect()->route('dashboard');
        // }

        $client = new Client();

        $cleanedUsername = strstr($request->username, '@', true) ?: $request->username;
        $pass = $request->passwordl;
        
        $response = $client->post('https://otp.rtaf.mi.th/api/v2/mfa/login', [
            'json' => [
                'user' => $cleanedUsername,  // This cuts off everything after @ if present
                'pass' => $request->password,
            ]
        ]);
    
        $data = json_decode($response->getBody(), true);

        if (isset($data['token'])) {
            //$token = $data['token'];
            // Store token in session
            //session(['token' => $token]);

            // ดึงข้อมูลผู้ใช้จากฐานข้อมูลท้องถิ่น
            $user = User::where('username', $cleanedUsername)->first();

            // ตรวจสอบว่าผู้ใช้มีอยู่ในฐานข้อมูลท้องถิ่นหรือไม่
            if (!$user) {
                // ถ้าผู้ใช้ไม่มีอยู่ ดึงรายละเอียดผู้ใช้จาก API และสร้างผู้ใช้ท้องถิ่น

                $user = User::create([
                    'username' => $data['user'],
                    'rank' => $data['rank'],
                    'fname' => $data['fname'],
                    'lname' => $data['lname'],
                    'position' => $data['user_position'],
                    'orgname' => $data['user_orgname'],
                ]);
                $user->syncRoles(['user']);
            }
            // สร้าง token พร้อมกับ abilities
            $abilities = ['view-dashboard', 'edit-profile']; // กำหนด abilities ที่ต้องการ
            $sanctumToken = $user->createToken('token-name', $abilities)->plainTextToken;

            // เก็บ token ใน session
            session(['token' => $sanctumToken]);
            session(['user_rank' => $data['rank']]);
            session(['user_fname' => $data['fname']]);
            session(['user_lname' => $data['lname']]);

            // เข้าสู่ระบบผู้ใช้
            Auth::login($user);

            //return redirect()->route('dashboard')->with('success', 'Login successful!');
            return redirect()->intended('/dashboard')->with('success', 'Login successful!');
        } else {
            return redirect()->route('login')->with('error', 'Login failed! Please check your credentials.');
        }
    }

    public function logout(Request $request)
    {

        $user = $request->user();
        //dd($user);
        // ลบ token ที่ใช้งานอยู่
        if ($user) {
            $user->tokens()->delete(); // ลบทั้งหมด หรือใช้
            //$user->currentAccessToken()->delete(); สำหรับลบเฉพาะ token ปัจจุบัน
        }

        // ลบ token จาก session
        $request->session()->forget('token');

        // ออกจากระบบผู้ใช้
        Auth::guard('web')->logout();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }


    public function user(Request $request)
    {
        $client = new Client();

        $response = $client->get('https://your-api-url/api/user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $request->bearerToken(),
            ]
        ]);

        return $response->getBody();
    }
}
