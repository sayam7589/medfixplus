<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $cleanedUsername = strstr($request->username, '@', true) ?: $request->username;

        // ======================================================
        // BYPASS MODE: ใช้ตอน API otp.rtaf.mi.th ล่ม
        // ตั้งค่า BYPASS_MFA_API=false ใน .env เมื่อ API กลับมาปกติ
        // ======================================================
        if (false) { // BYPASS_MFA_API — เปลี่ยนเป็น true เมื่อ API ล่ม
            $user = User::where('username', $cleanedUsername)->first();

            if (!$user) {
                return redirect()->route('login')->with('error', 'ไม่พบข้อมูลผู้ใช้ในระบบ กรุณาติดต่อผู้ดูแลระบบ');
            }

            $abilities = ['view-dashboard', 'edit-profile'];
            $sanctumToken = $user->createToken('token-name', $abilities)->plainTextToken;

            session(['token' => $sanctumToken]);
            session(['user_rank' => $user->rank]);
            session(['user_fname' => $user->fname]);
            session(['user_lname' => $user->lname]);

            Auth::login($user);
            $request->session()->regenerate();

            toast('เข้าสู่ระบบสำเร็จ', 'success');
            return redirect()->intended('/dashboard');
        }
        // ======================================================
        // END BYPASS MODE
        // ======================================================

        // --- โค้ด API เดิม (ใช้งานเมื่อ BYPASS_MFA_API=false) ---
        $client = new Client();

        try {
            $response = $client->post('https://otp.rtaf.mi.th/api/v2/mfa/login', [
                'timeout' => 15,
                'connect_timeout' => 10,
                'json' => [
                    'user' => $cleanedUsername,  // This cuts off everything after @ if present
                    'pass' => $request->password,
                ]
            ]);
        } catch (ConnectException $e) {
            // API ล่ม / ติดต่อไม่ได้ (ดู memory/fixes/mfa-api-bypass.md)
            Log::error('MFA API unreachable: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'ไม่สามารถติดต่อระบบยืนยันตัวตน (otp.rtaf.mi.th) ได้ในขณะนี้ กรุณาลองใหม่อีกครั้งหรือติดต่อผู้ดูแลระบบ');
        } catch (RequestException $e) {
            // API ตอบกลับ 4xx/5xx เช่น รหัสผ่านไม่ถูกต้อง
            Log::warning('MFA API login failed for user ' . $cleanedUsername . ': ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Login failed! Please check your credentials.');
        } catch (\Exception $e) {
            Log::error('MFA API unexpected error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ กรุณาลองใหม่อีกครั้ง');
        }

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

            // ป้องกัน session fixation
            $request->session()->regenerate();

            // เดิมใช้ ->with('success') ซึ่งไม่ถูกแสดงผล → เปลี่ยนเป็น toast (SweetAlert)
            toast('เข้าสู่ระบบสำเร็จ', 'success');
            return redirect()->intended('/dashboard');
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

        // ล้าง session และสร้าง CSRF token ใหม่
        $request->session()->invalidate();
        $request->session()->regenerateToken();

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
