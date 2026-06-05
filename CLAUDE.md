# Memory — MEDFIX+

## Project
Laravel app สำหรับระบบ MEDFIX+ (ทหาร/โรงพยาบาล)

## Terms
| Term | Meaning |
|------|---------|
| API ล่ม | otp.rtaf.mi.th ใช้ไม่ได้ชั่วคราว |
| bypass mode | Login ผ่าน local DB โดยไม่ผ่าน MFA API |

## Known Issues / Fixes
| Issue | File | วิธีแก้ |
|-------|------|---------|
| API MFA ล่ม (login ไม่ได้) | `app/Http/Controllers/AuthController.php` | ดูหัวข้อ "MFA API Login" ใน memory/ |

→ Details: memory/fixes/mfa-api-bypass.md
