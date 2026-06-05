# MFA API Login — วิธี Bypass และวิธีกลับมาใช้ API เดิม

## ไฟล์ที่เกี่ยวข้อง
`app/Http/Controllers/AuthController.php` → method `login()`

## API เดิม (MFA)
- **Endpoint:** `https://otp.rtaf.mi.th/api/v2/mfa/login`
- **Method:** POST
- **Payload:** `{ "user": "<username>", "pass": "<password>" }`
- **Response สำเร็จ:** มี field `token`, `rank`, `fname`, `lname`, `user_position`, `user_orgname`

## สถานะปัจจุบัน (Bypass Mode เปิดอยู่)
ไฟล์ AuthController.php มีบรรทัด:
```php
if (true) { // BYPASS_MFA_API — เปลี่ยนเป็น false เมื่อ API กลับมาปกติ
```
→ Login ผ่าน local DB โดยตรง ไม่ผ่าน API

## วิธีกลับมาใช้ MFA API เดิม
เมื่อ `otp.rtaf.mi.th` กลับมาปกติ:

1. เปิดไฟล์ `app/Http/Controllers/AuthController.php`
2. หาบรรทัด:
   ```php
   if (true) { // BYPASS_MFA_API — เปลี่ยนเป็น false เมื่อ API กลับมาปกติ
   ```
3. เปลี่ยนเป็น:
   ```php
   if (false) { // BYPASS_MFA_API
   ```
4. บันทึกไฟล์ — ระบบจะกลับไปใช้ API MFA ทันที ไม่ต้อง restart

## โค้ด API เดิม (อยู่ใน AuthController ข้างล่าง bypass block แล้ว)
```php
$client = new Client();
$response = $client->post('https://otp.rtaf.mi.th/api/v2/mfa/login', [
    'json' => [
        'user' => $cleanedUsername,
        'pass' => $request->password,
    ]
]);
$data = json_decode($response->getBody(), true);

if (isset($data['token'])) {
    $user = User::where('username', $cleanedUsername)->first();
    if (!$user) {
        $user = User::create([
            'username' => $data['user'],
            'rank'     => $data['rank'],
            'fname'    => $data['fname'],
            'lname'    => $data['lname'],
            'position' => $data['user_position'],
            'orgname'  => $data['user_orgname'],
        ]);
        $user->syncRoles(['user']);
    }
    $sanctumToken = $user->createToken('token-name', ['view-dashboard','edit-profile'])->plainTextToken;
    session(['token' => $sanctumToken, 'user_rank' => $data['rank'], 'user_fname' => $data['fname'], 'user_lname' => $data['lname']]);
    Auth::login($user);
    return redirect()->intended('/dashboard')->with('success', 'Login successful!');
}
```

## หมายเหตุ
- Bypass mode เช็คแค่ว่า username มีใน local DB หรือเปล่า — ไม่ได้เช็ค password
- User ที่ไม่เคย login มาก่อน (ยังไม่มีใน DB) จะยังเข้าไม่ได้ตอน bypass
- ถ้าจะสร้าง user ใหม่ตอน bypass ต้องเพิ่มผ่าน Tinker หรือ Seeder
