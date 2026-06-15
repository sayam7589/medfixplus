# MEDFIX+ Revamp — 10 มิ.ย. 2026

## สำรอง / Rollback
- Tag เวอร์ชันเดิม: `backup-before-revamp-2026-06-10`
- Branch งานนี้: `revamp/ui-bugfix-2026-06` (การแก้ทั้งหมดยังเป็น uncommitted changes บน branch นี้)

**Commit งานนี้** (รันใน terminal บนเครื่องคุณ):
```bash
git add -A
git commit -m "Fix bugs/security/error-handling + new MEDFIX+ UI theme"
```

**Rollback กลับเวอร์ชันเดิม:**
```bash
# ถ้ายังไม่ commit:
git checkout -- . && rm public/css/medfix-theme.css

# ถ้า commit แล้ว:
git checkout main   # หรือ git checkout backup-before-revamp-2026-06-10
```

## Bug / Security / Error handling ที่แก้

| ไฟล์ | สิ่งที่แก้ |
|------|-----------|
| `app/Http/Controllers/AuthController.php` | เพิ่ม validate username/password • try/catch รอบ MFA API (API ล่ม/รหัสผิด → ข้อความแจ้งเตือน แทน 500) + timeout 15s • ลบตัวแปร typo `$request->passwordl` • `session()->regenerate()` หลัง login (กัน session fixation) • `invalidate()+regenerateToken()` ตอน logout — **ไม่แตะ bypass block (`if (false)`) ตามที่ตกลง** |
| `app/Helpers/helpers.php` | กู้คืน `sendLineNotify()` ที่ถูก comment ไว้ (เดิมทำให้ POST `/notify` เกิด fatal error) |
| `app/Http/Controllers/NotifyController.php` | เพิ่ม `use Http` ที่หายไป (เดิม `handle()` เรียกแล้ว fatal) • validate message |
| `app/Http/Controllers/LineController.php` | กัน array key หายจาก webhook payload • try/catch รอบ HTTP ไป FastAPI และ LINE API • เช็ค token ก่อนส่ง + log error |
| `app/Http/Controllers/InvController.php` | `update()` ใช้ข้อมูลที่ผ่าน validation แทน `$request->all()` (กัน mass assignment) • **เพิ่มตรวจสิทธิ์หน่วยงานใน `destroy()`** (เดิมลบข้ามหน่วยได้) • `find→findOrFail` ใน `profile()` • แก้ rule typo `nullable\|\|integer` • เพิ่ม fallback return ใน `store()` (เดิมได้หน้าขาว) • กัน `hasRole(null)` |
| `app/Http/Controllers/MedfixController.php` | `closejob()` ใช้ `findOrFail` (เดิม id ผิด → crash) • `medfix_pic` เป็น `nullable\|image` • กัน `hasRole(null)` ใน `destroy()` • ลบ unreachable return |
| `app/Http/Controllers/ProjectController.php` | `store()/update()` ใช้ validated data แทน `$request->all()` |
| `app/Http/Controllers/UserPermissionController.php` | validate roles/permissions • กัน `syncRoles(null)` crash เมื่อไม่ติ๊ก checkbox |
| `app/Http/Controllers/DepartmentController.php` | แก้ validation key สะกดผิด `panang` → `panag` |
| `app/Http/Controllers/DashboardController.php` | validate input ของ `/dashboard/repairs/filter` (เดิมส่งค่าแปลก → 500) |
| `app/Http/Controllers/InvController.php.bak` | ลบไฟล์ backup ค้างใน repo (กู้ได้จาก git history) |

## UI ใหม่ (ไม่กระทบ behavior)

| ไฟล์ | สิ่งที่ทำ |
|------|----------|
| `public/css/medfix-theme.css` *(ใหม่)* | ธีมใหม่ทั้งระบบทับ AdminLTE: โทน navy-teal การแพทย์, การ์ด/ปุ่ม/ตาราง/ฟอร์ม/modal มุมโค้ง+เงานุ่ม, sidebar gradient เข้ม, กล่องสถิติ dashboard ไล่สี, หน้า login พื้นหลัง gradient, ปรับ responsive มือถือ — ครอบทุกหน้า (32 views) โดยไม่แก้ markup ของแต่ละหน้า |
| `resources/views/layouts/adminlte.blade.php` | โหลดธีมใหม่ • แก้บั๊ก adminlte.min.css โหลดซ้ำ 2 รอบ • โลโก้ใหม่ (ไอคอนการแพทย์ แทนโลโก้ AdminLTE) • avatar ผู้ใช้แบบไอคอน (แทนรูป stock) — เมนู/ลิงก์/JS เดิมทุกตัว |
| `resources/views/auth/login.blade.php` | ฟอนต์ Kanit + ธีมใหม่ + โลโก้ badge — ฟอร์ม, action, modal ช่วยเหลือ เหมือนเดิมทุกประการ |

## UX/UI Polish รอบ 2 — 10 มิ.ย. 2026 (จาก design critique)

| เรื่อง | รายละเอียด |
|--------|-----------|
| Page title | layout มี `<title>` แล้ว (เดิมไม่มีเลย — แท็บ browser ว่าง) ทุกหน้าตั้ง `@section('title')` ภาษาไทย, หน้า standalone (profile/search/create/tutorial) ตั้ง title ตรง ๆ |
| ภาษา | `lang="th"` ทุกหน้า • แก้สะกด "เเ"→"แ" ทั้งระบบ • Search→ค้นหาเมนู, ETC→อื่น ๆ, Sign In→เข้าสู่ระบบ, Close→ปิด, footer → Developed by Medical RTAF |
| Sidebar | หัวข้อที่มีเมนูย่อยเปลี่ยน href เป็น `#` (เดิมชี้ /projects_index ผิดหมวด — ต้นเหตุ highlight เพี้ยน) • ตำแหน่ง caret สม่ำเสมอ |
| Navbar | เพิ่ม user dropdown ขวาบน (ชื่อ+ออกจากระบบ) ใช้ฟอร์ม signout เดิม |
| Dashboard | KPI 4 ใบลิงก์หน้าจริง (เดิม `#`) • โครงการจัดซื้อเปลี่ยน bg-danger→bg-primary (สีแดงสื่อความหมายผิด) • badge ตาราง → `badge-info`/`badge-neutral` |
| Badge | `badge-default` (BS3 — มองไม่เห็น) → `badge-secondary` ใน medfix index/edit |
| Scripts ซ้ำ | ตัด DataTables/pdfmake 12 บรรทัดที่โหลดซ้ำกับ layout ออกจาก 7 หน้า (medfix index/edit, department, brands, problem x2, permission_index) — แก้ปัญหา `vfs_fonts.js` ทับฟอนต์ไทย `vfs_fonts_thai.js` ด้วย |
| ปุ่มอันตราย | ลบปุ่ม `data-card-widget="remove"` (กากบาทที่ทำให้การ์ด/ตารางหายทั้งหน้า) ออก 9 หน้า |
| ลิงก์ | `target="blank"` (typo) → `target="_blank" rel="noopener"` |
| Contrast (WCAG AA) | `--mf-warning` #e8a23d→#b45309, กล่องสถิติ warning ใช้ gradient เข้มขึ้น — ตัวหนังสือขาวผ่าน ≥4.5:1 |
| Select2 | ย้าย style เข้า `medfix-theme.css` ใช้สีธีม (เดิม override สีน้ำเงิน BS เดิมในหน้า create) |
| ฟอนต์ | Kanit โหลดเฉพาะ weight 300–700 (เดิมครบ 18 weight+italic) • เลิกโหลด kanitfont.css ซ้ำ |
| อื่น ๆ | aria-label ปุ่มไอคอน • แก้ heading h2→h3 ใน card dashboard • แก้ไฟล์ที่ truncate ค้าง (users/notpermission, medfix/blankpage) จาก git HEAD |

**ทดสอบหลัง pull:** `php artisan view:clear` แล้วเปิด login → dashboard (กด KPI ทั้ง 4) → รายการแจ้งซ่อม (ดู badge สถานะ, export PDF ไทย) → เพิ่มสินทรัพย์ (Select2 สีธีม) → เมนู sidebar กางถูกหมวด

## Theme v2.0 "Clean Minimal Medical" — 11 มิ.ย. 2026

แนวคิด: ลุคปี 2027 — โล่ง สว่าง เส้นบาง สีนิ่ง (เลิก gradient หนัก ๆ ของ v1) — **CSS/markup ฝั่ง view เท่านั้น ไม่แตะ controller/route/JS behavior**

| ไฟล์ | สิ่งที่ทำ |
|------|----------|
| `public/css/medfix-theme.css` | เขียนใหม่เป็น v2: **sidebar ขาว** (เดิม navy เข้ม) เมนู active = พื้น teal อ่อน + แถบ accent ซ้าย • หัวตารางขาว ตัวหนังสือเทา (เดิม navy gradient) • badge แบบ tint อ่อน+ตัวหนังสือเข้ม • การ์ดสี AdminLTE → หัวขาว+ขอบบนสีบาง • navbar ขาวโปร่ง blur • หน้า login พื้นสว่าง (เดิม gradient เข้ม) • เพิ่ม `.mf-kpi` สำหรับการ์ดสถิติ dashboard • คงไว้: anti-flicker DataTables, mf-pagebar, mf-active, badge-neutral, profile-avatar-icon, Select2, ปุ่ม soft ในตาราง |
| `resources/views/dashboard.blade.php` | KPI 4 ใบเปลี่ยนจาก small-box gradient → การ์ดขาว `.mf-kpi` (ลิงก์/ตัวเลขเดิมทุกตัว) • เพิ่ม **donut chart** "ปัญหาที่พบบ่อย" (top 6 จาก `$repairsByIssue` ที่หน้านี้มีอยู่แล้ว — ไม่เพิ่ม query) • อัปสีกราฟทุกตัวเป็น palette ใหม่ • id/endpoint เดิมหมด: `gongSelect, invTypeBar, lineChart, filterBtn, dashboard.repairs.filter, dashboard.invTypeCounts` |

Rollback ธีม v2 → v1: `git checkout -- public/css/medfix-theme.css resources/views/dashboard.blade.php` (ถ้ายังไม่ commit จะถอยกลับถึงเวอร์ชันก่อน revamp ทั้งหมด — ระวัง)

**ทดสอบหลัง pull:** `php artisan view:clear` → login (พื้นสว่างใหม่) → dashboard (KPI การ์ดขาว 4 ใบกดลิงก์ได้, donut+ตารางปัญหา, กราฟแท่งเลือกกอง, กรองช่วงเดือน) → หน้า ตาราง/ฟอร์ม อื่น ๆ ดู sidebar ขาว + หัวตารางใหม่

## Forms v2 — หน้า create/edit (11 มิ.ย. 2026)

CSS กลางใน `medfix-theme.css` (มีผลทุกฟอร์มอัตโนมัติ): label ชัด + เปลี่ยนสีธีมตอน focus ช่องนั้น • **ดอกจัน \* อัตโนมัติที่ช่อง required** (CSS `:has()` ไม่ต้องแก้ markup) • select เป็น chevron แบบ custom • ช่องที่ถูก disable (สเปคคอมฯ) เห็นชัดว่าปิด • ปุ่มอัปโหลด "เรียกดูไฟล์" ภาษาไทยโทนธีม • checkbox สีธีม • `.mf-form-actions` แถบบันทึก sticky ติดจอล่าง

| ไฟล์ | สิ่งที่ทำ (style/copy เท่านั้น — field name, action, JS เดิมหมด) |
|------|------|
| `inventorys/create.blade.php` | หัวการ์ดมีไอคอน ("ข้อมูลสินทรัพย์"/"ข้อมูลผู้รับ") • แถบ Save → sticky + "บันทึก/ล้างฟอร์ม" ไทย (Clear เป็น btn-default ไม่ชนปุ่มหลัก) • ลบดอกจัน manual ที่ซ้ำกับ CSS |
| `inventorys/edit.blade.php` | h1/breadcrumb "เพิ่ม"→"แก้ไข" (เดิมผิด) • หัวการ์ด+ไอคอน • Save sticky "บันทึกการแก้ไข" • ลบ inline Select2 style สีน้ำเงินเก่า (override ธีม) • ลบดอกจัน manual |
| `projects/create.blade.php` | หัวการ์ด+ไอคอน • ปุ่ม "บันทึก" + ไอคอน |
| `projects/edit.blade.php` | หัวการ์ด+ไอคอน • "บันทึกการแก้ไข" • Current file→ไฟล์ปัจจุบัน + `rel="noopener"` • **ลบ checkbox "I agree to terms" เศษ template** (ไม่ถูกใช้ใน controller) |
| `department/create.blade.php` | หัวการ์ด+ไอคอน • จัด layout ช่องแผนก+ปุ่มเพิ่มให้ตรงแนว • modal แก้ไขมี title แล้ว |
| `medfix/edit.blade.php` | breadcrumb Home→หน้าหลัก ลิงก์ /dashboard |

**ทดสอบ:** เพิ่มสินทรัพย์ (เลือกประเภทที่ไม่ใช่คอม → ช่องสเปคจางลงชัด, แถบบันทึกลอยล่าง, ล้างฟอร์ม) → แก้ไขสินทรัพย์ (Select2 โทนธีม) → เพิ่ม/แก้โครงการ (อัปโหลดไฟล์ปุ่มไทย) → เพิ่มกอง/แผนก + modal แก้ไข

## Sweep 2027 รอบ 3 — จุดที่เหลือทั้งระบบ (11 มิ.ย. 2026)

| ไฟล์ | สิ่งที่ทำ (visual/copy เท่านั้น) |
|------|------|
| `inventorys/profile.blade.php` (หน้าสแกน QR) | **โหลด medfix-theme.css แล้ว** (เดิมไม่มีธีมเลย) • Kanit เหลือ 5 weights (เดิม 18+italic) • navbar ขาว blur + โลโก้ chip • Sign Out→ออกจากระบบ • `tag tag-*` (BS3 ไม่มีสไตล์)→badge ใหม่ • `progress-bar-danger` (BS3)→`mf-progress-bar` • badge แดงตัวเลขสถิติ→โทนกลาง • สี donut chart→palette ธีม • แก้ `</td>` ปิด `<th>` ผิด 2 จุด |
| `medfix/search.blade.php` | โหลดธีม + navbar เดียวกับ profile • Kanit trim • หัวการ์ด "ค้นหาครุภัณฑ์ตามกอง"+ไอคอน • SignOut→ออกจากระบบ (ปุ่มเดิมไม่ได้ต่อ logout จริง — คงพฤติกรรมเดิม จดไว้เป็น known issue) |
| `users/notpermission.blade.php` | จาก "404 Error Page / Oops! นะจ๊ะ" → หน้า "ไม่มีสิทธิ์เข้าถึง" แบบ state page สมัยใหม่ (ไอคอนล็อก + ปุ่มกลับหน้าหลัก + อีเมลแอดมินเดิม) |
| `medfix/blankpage.blade.php` | จาก template "Blank Page/Start creating..." → state page "ไม่พบข้อมูล" ภาษาไทย |
| `medfix/create.blade.php` | จาก HTML เปล่าไร้ธีม → หน้าในระบบ (extends layout, form POST `medfix.store` + ปุ่มเดิม) |
| `tutorial.blade.php` | Kanit + header sticky + กรอบรูปแบบธีม + `loading="lazy"` + alt ไทย |
| `medfix/index, users/permission, users/permission_index` | breadcrumb `Home`(href="#") → หน้าหลัก `/dashboard` |
| `inventorys/view.blade.php` | modal QR: Close→ปิด, Print→พิมพ์+ไอคอน |
| `public/css/medfix-theme.css` (v2.1) | `.mf-progress-bar`/`.progress-xs` เป็นของกลาง • `.mf-state-page/.mf-state-icon` • **ธีม SweetAlert2** (popup/toast/ปุ่ม/ไอคอน โทนเดียวกับระบบ) • focus-visible ring (a11y คีย์บอร์ด) • `::selection` โทนมิ้นท์ |

จุดที่ตั้งใจ **ไม่แก้** (พฤติกรรมเดิมแม้จะ buggy): ปุ่ม SignOut หน้า search ไม่ได้ submit logout จริง • `profile.blade.php` สคริปต์ `new bootstrap.Modal(...)` (BS4 ไม่มี window.bootstrap — modal แจ้งเตือนไม่เด้งอยู่แล้ว) + id `exampleModal3` ซ้ำ 2 จุด • jQuery โหลดซ้ำ 2 ตัวใน profile (ลำดับ script ผูกกับ behavior ปัจจุบัน) • `welcome.blade.php` (default Laravel ไม่ได้ใช้ใน route)

**ทดสอบ:** สแกน QR เปิดหน้าครุภัณฑ์ (ธีมใหม่, แถบ progress มีสี, donut โทนธีม, แจ้งซ่อม/ลงทะเบียน/ปิดงาน modal ทำงานเดิม) → หน้าค้นหา (ตาราง+ปุ่มแจ้งซ่อม) → เข้าหน้าที่ไม่มีสิทธิ์ (เห็นหน้า 403 ใหม่) → ลบรายการใดก็ได้ (SweetAlert โทนธีม)

## หมายเหตุ
- Business logic, routes, ชื่อ field, redirect targets — เดิมทั้งหมด
- ควรรัน `php artisan view:clear` หลัง pull แล้วทดสอบ: login, แจ้งซ่อม, ปิดงาน, CRUD สินทรัพย์/โครงการ, QR
- เตือน production: `.env` มี `APP_DEBUG=true` — ควรเป็น `false` บนเครื่องจริง (debug page เปิดเผยข้อมูลระบบ)
- จุดที่ "ตั้งใจไม่แก้": bypass MFA block, URL hardcode `medfix.site` ใน QR, query นับงานซ่อมใน sidebar
