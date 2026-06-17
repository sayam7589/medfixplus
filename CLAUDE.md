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

## Design — Impeccable
ติดตั้งสกิล **Impeccable** ไว้ที่ `.claude/skills/impeccable/` (frontend design vocabulary, 23 commands).
- เรียกใช้ตอนทำงาน UI/หน้าจอ/Blade: `/impeccable <command> <target>` เช่น `/impeccable polish`, `/impeccable critique`, `/impeccable audit`
- ตรวจ AI slop / anti-patterns: `node .claude/skills/impeccable/scripts/detect.mjs <path>` (ออฟไลน์ ไม่ต้องต่อเน็ต)
- ครั้งแรกของโปรเจกต์ ควรรัน `/impeccable init` เพื่อสร้าง `PRODUCT.md` (บริบทแบรนด์/ผู้ใช้) ก่อน
