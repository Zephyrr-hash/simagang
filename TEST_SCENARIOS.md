# 🧪 Testing Scenarios - SIMAGANG

Panduan lengkap untuk melakukan manual testing pada setiap fitur aplikasi SIMAGANG.

---

## 📝 Testing Checklist Overview

| Module | Status | Priority | Notes |
|--------|--------|----------|-------|
| Public Access | ✅ Verified | High | Homepage & login working |
| Authentication | ✅ Verified | High | Laravel UI functional |
| Mahasiswa Flow | 🔄 Need Testing | High | Apply & logbook |
| Mitra Flow | 🔄 Need Testing | High | Lowongan & approval |
| Dospem Flow | 🔄 Need Testing | Medium | Bimbingan review |
| Supervisor Flow | 🔄 Need Testing | Medium | Logbook & scoring |
| Departemen Flow | 🔄 Need Testing | Medium | Admin functions |
| Project Management | 🔄 Need Testing | High | New feature |
| File Upload | 🔄 Need Testing | High | Images & documents |
| PDF Export | 🔄 Need Testing | Medium | Logbook export |
| API Wilayah | 🔄 Need Testing | Low | Cascading dropdown |

---

## 🌐 Test Scenario 1: Public Access

### 1.1 Homepage (Public Lowongan List)
**URL:** http://127.0.0.1:8000

**Expected:**
- [x] Page loads successfully (200 OK)
- [ ] Display list of available lowongan
- [ ] Show mitra name, category, quota
- [ ] "Lihat Detail" button functional
- [ ] "Masuk" button redirects to login

**Test Steps:**
1. Open browser
2. Navigate to http://127.0.0.1:8000
3. Verify lowongan displayed:
   - Frontend Developer (INDICO)
   - Backend Developer (INDICO)
   - Technical Support Specialist (BYD)
4. Click "Lihat Detail" on one lowongan
5. Verify detail page shows complete information

**Test Data:**
- Expected lowongan count: 3

---

### 1.2 Lowongan Detail (Public)
**URL:** http://127.0.0.1:8000/detail/{id}

**Expected:**
- [ ] Show full lowongan details
- [ ] Show mitra information
- [ ] Show requirements
- [ ] "Apply" button only for logged-in mahasiswa
- [ ] Non-mahasiswa see login prompt

**Test Steps:**
1. Navigate to http://127.0.0.1:8000/detail/2
2. Verify all information displayed
3. Note "Apply" button behavior

---

## 🔐 Test Scenario 2: Authentication

### 2.1 Login Flow
**URL:** http://127.0.0.1:8000/login

**Test Accounts:**
| Email | Role | Expected Dashboard |
|-------|------|-------------------|
| admin2@simagang.id | Departemen | /depart/home |
| zephyr@gmail.com | Mitra | /mitra/home |
| lubis@gmail.com | Dosen | /dosen/home |
| raka@gmail.com | Supervisor | /supervisor/home |
| jaka@gmail.com | Mahasiswa | /mahasiswa/home |

**Test Steps:**
1. Navigate to login page
2. Enter email and password
3. Click "Login"
4. Verify redirect to correct dashboard
5. Verify role-specific menu displayed
6. Try accessing other role's pages (should be blocked)

**Expected Behaviors:**
- [ ] Successful login redirects to role dashboard
- [ ] Failed login shows error message
- [ ] Empty fields show validation errors
- [ ] Invalid credentials show error
- [ ] Remember me checkbox works
- [ ] Logout works correctly

---

### 2.2 Logout
**Test Steps:**
1. Click logout button
2. Verify redirect to homepage
3. Try accessing protected pages (should redirect to login)

---

## 👨‍🎓 Test Scenario 3: Mahasiswa Flow

### 3.1 Complete Profile (First Time)
**URL:** http://127.0.0.1:8000/profile

**Test Steps:**
1. Login as mahasiswa (jaka@gmail.com)
2. If profile incomplete, verify redirect to profile page
3. Fill all required fields:
   - Nama lengkap
   - NIM
   - Telepon
   - Jenis kelamin
   - Tanggal lahir
   - Jurusan
   - Departemen
   - Pengalaman
   - Skills (optional)
4. Upload foto (optional)
5. Save profile

**Expected:**
- [ ] Validation errors for empty required fields
- [ ] Success message on save
- [ ] Redirect to dashboard after completion
- [ ] Profile data persisted

---

### 3.2 Browse Lowongan
**URL:** http://127.0.0.1:8000/mahasiswa/home

**Test Steps:**
1. Login as mahasiswa
2. View available lowongan
3. Filter by category (if available)
4. Search by keyword (if available)

**Expected:**
- [ ] All lowongan displayed
- [ ] Can view lowongan details
- [ ] "Apply" button available for each

---

### 3.3 Apply for Internship
**URL:** http://127.0.0.1:8000/mahasiswa/apply/{lowongan_id}

**Test Steps:**
1. Click "Apply" on a lowongan
2. Fill application form:
   - Motivation letter
   - Start date
   - Duration
3. Upload CV (if required)
4. Submit application

**Expected:**
- [ ] Form validation works
- [ ] File upload successful
- [ ] Success alert displayed
- [ ] Application appears in "Pengajuan Saya"
- [ ] Cannot apply twice for same lowongan

---

### 3.4 View Application Status
**URL:** http://127.0.0.1:8000/mahasiswa/diajukan

**Test Steps:**
1. Navigate to "Pengajuan Saya"
2. View list of applications

**Expected Status:**
- [ ] Pending (menunggu approval mitra)
- [ ] Diterima (approved by mitra)
- [ ] Ditolak (rejected)
- [ ] Selesai (completed)

---

### 3.5 Create Logbook Entry
**URL:** http://127.0.0.1:8000/project/{project_id}/logbook/create

**Prerequisites:** Application must be approved and project created by SPV

**Test Steps:**
1. Navigate to project detail
2. Click "Tambah Logbook"
3. Fill form:
   - Tanggal
   - Kegiatan (activity description)
   - Durasi (hours)
4. Upload file (optional)
5. Submit

**Expected:**
- [ ] Date validation
- [ ] Activity text required
- [ ] Duration must be positive number
- [ ] File upload works
- [ ] Success message
- [ ] Entry appears in logbook list
- [ ] Can edit own entries
- [ ] Can delete own entries
- [ ] SPV can add catatan (notes)

---

### 3.6 Submit Bimbingan Report
**URL:** http://127.0.0.1:8000/project/{project_id}/bimbingan/create

**Test Steps:**
1. Navigate to project
2. Click "Tambah Bimbingan"
3. Fill form:
   - Tanggal
   - Topik pembahasan
   - Kendala yang dihadapi
   - Rencana selanjutnya
4. Upload file (optional)
5. Submit

**Expected:**
- [ ] All fields validated
- [ ] File upload works
- [ ] Submission successful
- [ ] Dosen receives notification (check as dosen)
- [ ] Can view feedback from dosen

---

## 🏢 Test Scenario 4: Mitra Flow

### 4.1 Create Lowongan
**URL:** http://127.0.0.1:8000/lowongan/create

**Test Steps:**
1. Login as mitra (zephyr@gmail.com)
2. Click "Buat Lowongan Baru"
3. Fill form:
   - Nama lowongan
   - Deskripsi lengkap
   - Kategori
   - Jumlah mahasiswa
   - Durasi (bulan)
   - Lokasi
   - Telepon
   - Requirements
4. Upload foto lowongan
5. Submit

**Expected:**
- [ ] Form validation works
- [ ] Image upload successful
- [ ] Success alert
- [ ] Lowongan appears in public list
- [ ] Can edit lowongan
- [ ] Can delete lowongan

---

### 4.2 Review Applicants
**URL:** http://127.0.0.1:8000/mitra/pendaftar

**Test Steps:**
1. Navigate to "Daftar Pendaftar"
2. View list of applicants for each lowongan
3. Click "Detail" on an applicant
4. Review:
   - Student profile
   - Motivation letter
   - CV (if uploaded)
   - Skills

**Expected:**
- [ ] All applicants listed
- [ ] Can filter by lowongan
- [ ] Can view student details
- [ ] Approve/Reject buttons available

---

### 4.3 Approve/Reject Application
**URL:** http://127.0.0.1:8000/mitra/pendaftar/{id}

**Test Steps:**

**Approve:**
1. Click "Terima"
2. Confirm action
3. Verify status changed to "Diterima"

**Reject:**
1. Click "Tolak"
2. Enter rejection reason
3. Confirm action
4. Verify status changed to "Ditolak"

**Expected:**
- [ ] Confirmation dialog appears
- [ ] Status updated in database
- [ ] Student receives notification
- [ ] Application moves to "Magang Aktif" if approved
- [ ] Departemen can assign dospem

---

### 4.4 View Active Interns
**URL:** http://127.0.0.1:8000/mitra/magang

**Test Steps:**
1. Navigate to "Magang Aktif"
2. View list of accepted students
3. Click detail on a student
4. View:
   - Progress
   - Logbook entries
   - Assigned supervisor
   - Assigned dosen

**Expected:**
- [ ] All active interns listed
- [ ] Can view progress
- [ ] Can end internship when complete

---

### 4.5 End Internship
**URL:** http://127.0.0.1:8000/mitra/magang/{id}

**Test Steps:**
1. View intern detail
2. Click "Akhiri Magang"
3. Confirm action

**Expected:**
- [ ] Confirmation dialog
- [ ] Status changed to "Selesai"
- [ ] Student notified
- [ ] Final score must be submitted by SPV

---

## 👨‍🏫 Test Scenario 5: Dosen Pembimbing Flow

### 5.1 View Assigned Students
**URL:** http://127.0.0.1:8000/dosen/home

**Test Steps:**
1. Login as dosen (lubis@gmail.com)
2. View dashboard
3. See list of assigned students

**Expected:**
- [ ] All assigned students displayed
- [ ] Can see student progress
- [ ] Can see pending bimbingan submissions

---

### 5.2 Review Bimbingan Submission
**URL:** http://127.0.0.1:8000/project/{pid}/bimbingan/{bid}

**Test Steps:**
1. Click on bimbingan submission
2. Read submission:
   - Topik pembahasan
   - Kendala
   - Rencana selanjutnya
   - Attachment (if any)
3. Provide feedback
4. Submit

**Expected:**
- [ ] Can view all submission details
- [ ] Can download attachment
- [ ] Feedback form available
- [ ] Success message on feedback submission
- [ ] Student receives feedback notification

---

## 👷 Test Scenario 6: Supervisor Flow

### 6.1 Create Project
**URL:** http://127.0.0.1:8000/project/create

**Test Steps:**
1. Login as supervisor (raka@gmail.com)
2. Click "Buat Project Baru"
3. Select intern (from assigned interns)
4. Fill project details:
   - Nama project
   - Deskripsi
   - Target/deliverables
5. Submit

**Expected:**
- [ ] Only assigned interns shown
- [ ] Validation works
- [ ] Project created successfully
- [ ] Project appears in project list
- [ ] Mahasiswa can see project

---

### 6.2 Review Logbook Entries
**URL:** http://127.0.0.1:8000/project/{id}

**Test Steps:**
1. Navigate to project detail
2. View logbook entries
3. Click on an entry
4. Review activity
5. Add catatan (notes/feedback)
6. Submit

**Expected:**
- [ ] All logbook entries listed
- [ ] Can filter by date
- [ ] Can add feedback
- [ ] Mahasiswa sees feedback
- [ ] Can approve/reject entry (if needed)

---

### 6.3 Score Student (Penilaian)
**URL:** http://127.0.0.1:8000/supervisor/penilaian

**Test Steps:**
1. Navigate to "Penilaian"
2. View list of completed interns
3. Click on student
4. Fill assessment form:
   - Nilai (0-100)
   - Keterangan/catatan
5. Submit

**Expected:**
- [ ] Only completed interns shown
- [ ] Validation: score 0-100
- [ ] Success message
- [ ] Score saved to database
- [ ] Student can view score

---

## 🏛️ Test Scenario 7: Departemen Flow

### 7.1 Manage Users
**URL:** http://127.0.0.1:8000/users

**Test Steps:**
1. Login as departemen (admin2@simagang.id)
2. Navigate to "Kelola User"
3. View user list
4. Create new user
5. Edit user
6. Delete user (if allowed)

**Expected:**
- [ ] All users listed
- [ ] Can filter by role
- [ ] Create user form works
- [ ] Edit user works
- [ ] Delete requires confirmation

---

### 7.2 View All Students
**URL:** http://127.0.0.1:8000/depart/mahasiswa

**Test Steps:**
1. Navigate to "Daftar Mahasiswa"
2. View all registered students
3. Click detail on a student
4. View complete profile

**Expected:**
- [ ] All students listed
- [ ] Can search by name/NIM
- [ ] Can view complete profile
- [ ] Can see application history

---

### 7.3 Assign Dosen Pembimbing
**URL:** http://127.0.0.1:8000/depart/pengajuan

**Test Steps:**
1. Navigate to "Pengajuan Magang"
2. View applications approved by mitra
3. Click on application
4. Select dosen pembimbing from dropdown
5. Assign

**Expected:**
- [ ] Only approved applications shown
- [ ] Dosen dropdown populated
- [ ] Validation works
- [ ] Assignment successful
- [ ] Dosen receives notification
- [ ] Student receives notification

---

## 📄 Test Scenario 8: PDF Export

### 8.1 Export Logbook to PDF
**URL:** http://127.0.0.1:8000/project/{id}/logbook/cetak

**Test Steps:**
1. Navigate to project
2. Click "Cetak Logbook" / "Export PDF"
3. PDF should download

**Expected:**
- [ ] PDF generated successfully
- [ ] Contains all logbook entries
- [ ] Proper formatting
- [ ] Student info included
- [ ] Project info included
- [ ] SPV catatan included

---

## 📤 Test Scenario 9: File Upload

### 9.1 Upload Profile Photo
**Test Steps:**
1. Edit profile
2. Choose image file (JPG/PNG)
3. Upload

**Expected:**
- [ ] File type validation (only images)
- [ ] File size validation (max 2MB)
- [ ] Success message
- [ ] Image displayed in profile
- [ ] Old image replaced

---

### 9.2 Upload Lowongan Photo
**Test Steps:**
1. Create/edit lowongan
2. Upload image
3. Submit

**Expected:**
- [ ] File validation works
- [ ] Image saved to public/images/
- [ ] Image displayed in lowongan list
- [ ] Image displayed in detail page

---

### 9.3 Upload CV/Documents
**Test Steps:**
1. Apply for lowongan
2. Upload CV (PDF)
3. Submit application

**Expected:**
- [ ] PDF upload works
- [ ] File size limit enforced
- [ ] File accessible by mitra
- [ ] Can download file

---

### 9.4 Upload Logbook/Bimbingan Attachments
**Test Steps:**
1. Create logbook/bimbingan
2. Attach file (PDF/DOC/image)
3. Submit

**Expected:**
- [ ] Multiple file types accepted
- [ ] File saved successfully
- [ ] Can download attachment
- [ ] Dosen/SPV can view attachment

---

## 🔗 Test Scenario 10: API Wilayah (Cascading Dropdown)

### 10.1 Provinsi → Kabupaten → Kecamatan
**Context:** Mitra profile form

**Test Steps:**
1. Edit profile as mitra
2. Select provinsi from dropdown
3. Verify kabupaten dropdown populated
4. Select kabupaten
5. Verify kecamatan dropdown populated
6. Select kecamatan
7. Save profile

**Expected:**
- [ ] Provinsi dropdown loads on page load
- [ ] Kabupaten loads when provinsi selected
- [ ] Kecamatan loads when kabupaten selected
- [ ] AJAX requests successful
- [ ] Data saved correctly
- [ ] Cascading works on edit (preserves selection)

**API Endpoints:**
- GET /api/wilayah/provinsi
- GET /api/wilayah/kabupaten?provinsi_id={id}
- GET /api/wilayah/kecamatan?kabupaten_id={id}

---

## 🔒 Test Scenario 11: Security & Authorization

### 11.1 Role-based Access Control
**Test Steps:**
1. Login as mahasiswa
2. Try to access:
   - /mitra/home (should be blocked)
   - /depart/home (should be blocked)
   - /dosen/home (should be blocked)
3. Verify redirect to homepage with error message

**Expected:**
- [ ] Access denied for unauthorized roles
- [ ] Error message displayed
- [ ] User stays on allowed pages

---

### 11.2 Profile Completion Enforcement
**Test Steps:**
1. Create new user with incomplete profile
2. Try to access any feature
3. Verify redirect to profile page
4. Complete profile
5. Verify can access features

**Expected:**
- [ ] Incomplete profile redirects to /profile
- [ ] Banner/message displayed
- [ ] Cannot use features until complete
- [ ] After completion, full access granted

---

### 11.3 CSRF Protection
**Test Steps:**
1. Submit any form
2. Verify @csrf token included
3. Try submitting without token (should fail)

**Expected:**
- [ ] All forms have CSRF token
- [ ] Submission fails without token
- [ ] Proper error message

---

### 11.4 Data Ownership
**Test Steps:**
1. Login as mahasiswa A
2. Try to edit logbook of mahasiswa B (different user)
3. Should be blocked

**Expected:**
- [ ] Can only edit own data
- [ ] Cannot edit other users' data
- [ ] Authorization checks work

---

## 📊 Test Scenario 12: Data Validation

### 12.1 Form Validation
**Test each form for:**
- [ ] Required fields show error if empty
- [ ] Email format validation
- [ ] Phone number format
- [ ] Date format and range
- [ ] File type validation
- [ ] File size validation
- [ ] Numeric range validation (e.g., score 0-100)
- [ ] Text length limits
- [ ] Unique constraints (e.g., email, NIM)

---

### 12.2 Database Constraints
**Test:**
- [ ] Foreign key constraints work
- [ ] Cannot delete record with dependencies
- [ ] Cascade deletes work (if configured)
- [ ] Unique constraints enforced

---

## 🐛 Test Scenario 13: Error Handling

### 13.1 404 Not Found
**Test Steps:**
1. Navigate to non-existent route
2. Verify 404 page displayed

---

### 13.2 500 Internal Server Error
**Simulate by:**
- Incorrect database query
- Missing file
- Invalid data type

**Expected:**
- [ ] Error page displayed (if APP_DEBUG=false)
- [ ] Error logged to laravel.log
- [ ] No sensitive data exposed

---

### 13.3 Validation Errors
**Expected:**
- [ ] Friendly error messages
- [ ] Highlighted fields
- [ ] Preserved form data (old input)
- [ ] Multiple errors displayed

---

## 🎨 Test Scenario 14: UI/UX

### 14.1 Responsive Design
**Test on:**
- [ ] Desktop (1920x1080)
- [ ] Laptop (1366x768)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)

**Expected:**
- [ ] Layout adapts to screen size
- [ ] No horizontal scroll
- [ ] Touch-friendly on mobile
- [ ] Readable text

---

### 14.2 Browser Compatibility
**Test on:**
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Edge (latest)
- [ ] Safari (if available)

---

### 14.3 Accessibility
**Check:**
- [ ] Form labels present
- [ ] Alt text for images
- [ ] Keyboard navigation works
- [ ] Focus indicators visible
- [ ] Color contrast adequate

---

## 📈 Test Scenario 15: Performance

### 15.1 Page Load Time
**Test:**
- [ ] Homepage loads < 2 seconds
- [ ] Dashboard loads < 3 seconds
- [ ] List pages with pagination
- [ ] No N+1 query issues (check logs)

---

### 15.2 Database Queries
**Use Laravel Debugbar or log:**
- [ ] Count queries per page
- [ ] Check for N+1 problems
- [ ] Verify eager loading used

---

## 📋 Bug Report Template

When you find a bug, document it:

```markdown
**Bug Title:** [Short description]

**Severity:** Critical / High / Medium / Low

**Environment:**
- Browser: [Chrome 90]
- OS: [Windows 10]
- User Role: [Mahasiswa]

**Steps to Reproduce:**
1. Step 1
2. Step 2
3. Step 3

**Expected Result:**
What should happen

**Actual Result:**
What actually happened

**Screenshot/Error Message:**
[Attach if available]

**Additional Notes:**
Any other relevant information
```

---

## ✅ Testing Sign-off

After completing all tests, fill this checklist:

### Critical Features
- [ ] Login/Logout works for all roles
- [ ] Mahasiswa can apply for lowongan
- [ ] Mitra can approve/reject
- [ ] Logbook entries can be created
- [ ] Bimbingan submissions work
- [ ] Scoring works
- [ ] File uploads work

### Important Features
- [ ] Profile management works
- [ ] Project management works
- [ ] PDF export works
- [ ] API endpoints work
- [ ] Notifications display correctly

### Nice-to-Have Features
- [ ] Search/filter works
- [ ] Pagination works
- [ ] UI is responsive
- [ ] Performance is acceptable

### Security
- [ ] Role-based access enforced
- [ ] CSRF protection active
- [ ] Data ownership enforced
- [ ] File upload secured

---

**Tested By:** _________________  
**Date:** _________________  
**Sign:** _________________

---

*Test Plan Version 1.0 - Generated 24 Juni 2026*
