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

## Port to Next.js — laravel-to-nextjs
ติดตั้งสกิล **laravel-to-nextjs** ไว้ที่ `.claude/skills/laravel-to-nextjs/` (สำเนาเอกสารอยู่ที่ `docs/laravel-to-nextjs/`)
- ใช้ตอนทำโปรเจกต์คู่ขนาน `C:\laragon\www\medfix-next` (Next.js 15 App Router + Prisma + Auth.js v5 + Tailwind/shadcn)
- Next.js ใช้ **DB `medfix` ตัวเดียวกับ Laravel** → ⛔ ห้ามรัน `prisma migrate` เด็ดขาด ใช้ `prisma db pull` เท่านั้น
- Schema ยังเป็นของ Laravel: เพิ่มคอลัมน์ต้อง `php artisan make:migration` แล้วค่อย `npm run db:pull`
- ทุก Server Action ต้องขึ้นต้นด้วย `await requireRole(...)` — `middleware.ts` ไม่ป้องกัน Server Action
- ลำดับงาน: Prisma → Auth → Layout → หน้าอ่าน → หน้าเขียน → Dashboard → Cutover (ดู `references/roadmap.md`)
