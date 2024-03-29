# Development Log Kept from 06-04-2021

## Issues

### Old

```
1) (DONE) Add fields modified in migrations to the Models $fillable
2) Menu nav bug cause of receipt for student and receipt generation having same route name
3) (DONE) Implement graduation logic
3) (Fixed) Fees receipt generation failing
4) (Fixed) Generic Receipt were not able to generate once school fees was nil

```

### Issues from 23-05-2021 meeting

-   (26/may 10:58am) User should see select year screen after login
    -   Fixed login background shows even on dashboard
-   (26/may 05:03pm) Dashboard UI instructions
    -   First Row: Enquiry, Gross Admissions
    -   Second Row: Gross Receivable, Collection, Collection Due
    -   Birthday Reminder: Name, Program, Division
-   (26/may 07:55pm) Enquiry, Admission: Stats Cards on top by program and clickable to filter data
-   (26/may 08:10pm) Enquiry: Optional Reference, (Issue) Enquiry UI is very compact
-   (26/may 08:45pm) Admission: Optional Photo, Discount empty errors total fees calculation make default zero
-   (26/may 08:45pm) Installment (Month and Year in select option)
-   (27/may 06:05pm) Kit Stock Log
-   (28/may 08:58am) Installment Screen name ('Fees Installments - Annexure A')
-   (28/may 08:58am) Declaration form
-   Delete Installment if admission not added

### Issues from 14-06-2021 meeting

-   (14/jun 11:59pm) Second page of print is not visible Declaration
-   (14/jun 11:59pm) Declaration Button
-   (15/jun 11:35am) Timezone issues
-   (15/jun 11:35am) Fixed Division Attendance not scoping based on school
-   Syllabus Copy Button

## Dashboard

-   (9/apr 11:00am) Fees Rate Card
-   (15/apr 5:08pm) Removed Fees Rate Card, Added FeesMetrics, SchoolMetrics

## Commits history

-   (7/apr 12:22pm) Academic Year can now start from any month, Also added ability edit school code and validations
-   (7/apr 05:00pm) Small changes from (06-04) done
-   (7/apr 09:40pm) Fixed enquiry for working year
-   (9/apr 11:00am) Added student PRN and Fees Rate Card can be filled partially and dashboard widget for fees rate card
-   (9/apr 05:15pm) School Fees Receipt changes made, Validation for fees overpay than balance amount, disabled notifications.
-   (10/apr 09:33pm) Fixed Academic Year sync issues
-   (10/apr 02:41pm) Fees Receipt Generation
-   (10/apr 05:13pm) Invoice Prints
-   (11/apr 12:30pm) Payment Due Reports and CSV export library, pdf also
-   (11/apr 02:14pm) Added cancel for the receipts
-   (11/apr 02:38pm) Added Cancelled receipts logs reports, changed csv export name scheme
-   (11/apr 05:05pm) Online Collection reports added, custom filter layout added
-   (11/apr 05:56pm) Add Daily Collection, Minor tweaks other reports and filters
-   (11/apr 06:42pm) Admission Report and added batch filter in Program Selection
-   (12/apr 11:52am) Enquiry Report (Excel, PDF) now admission create will also save student_id in enquiry
-   (12/apr 04:27pm) Individual Student Receipt Report Export, some query optimizations
-   (13/apr 09:07am) Fixed Fees Receipt generation error on create as some students didn't had admission that year solved by using Admission instead of student Payment Due error on no data fixed, changed text cancel to delete for receipt action
-   (13/apr 11:17am) Print button is in warning style everywhere and fixed every model loading same data with multiple queries, Multiple Center Head
-   (14/apr 08:40am) Removed fees installments from admission moved to separate model, screen to add installment added
-   (14/apr 08:40am) Installment deduction while paying receipt, Installment tab in receipts
-   (14/apr 07:25pm) Added receipt deletion approval, if user doesn't have receipt.delete permission then it will show request deletion button now.
-   (15/apr 05:08pm) Added School And Fees Metrics, implemented caching, fixed enquiry report not having scopes, Admin and School Dashboard separation
-   (16/apr 06:20pm) Added Graduation Screen and Logic, Installment and Admission bugs fixed, now admission cannot be added without adding fees first. Minor fixes in Dashboard.
-   (17/apr 12:10am) Properly set up the Laravel Excel Package on local, Also exported users table as expected
-   (17/apr 12:50pm) Demoed excel exports on server and added remaining xlsx exports for admin specified in Exports task
-   (17/apr 04:30pm) Added User Management for Schools
-   (18/apr 03:43pm) Kit Stock Management, Ability to assign kit to the student
-   (18/apr 07:52pm) Validations before assigning kit and added field in admission reports for both user and admin
-   (18/apr 08:22pm) Added Kit Stock Reports for admin
-   (27/apr 05:48pm) Admin Screen for syllabus: adding, updating, deleting using vue components
-   (28/apr 11:24pm) School can add and assign divisions to teachers
-   (28/apr 11:40pm) Table and Delete added for divisions
-   (29/apr 01:25pm) Ability to assign division to the student
-   (29/apr 09:35pm) Teachers will be able to see the list of all students under their divisions, fixed filter layouts views
-   (30/apr 11:30am) Fixed school users management
-   (01/may 01:02pm) Subjects can be assigned under a programme
-   (01/may 01:25pm) ProgramSubjects Association List and Delete options added
-   (01/may 11:00pm) Subjects list screen for teacher with all the books as options
-   (02/may 03:11pm) Clicking on book reveals syllabus and Submit mark request and validate
-   (03/may 12:10pm) Receipt is compatible with new ApprovalService based API
-   (06/may 06:30pm) Approval for syllabus taught added, API for approval is fully flexible now
-   (07/may 04:32pm) Syllabus Completed can be seen marked inside book screen
-   (14/may 02:05pm) Record student attendance and see list of added attendance.
-   (19/may 06:37pm) Attendance Report
-   (20/may 04:03pm) Fixed permission related issues
-   (25/may 11:25pm) Fixed Attendance and receipt and invoice prints
-   (28/may 08:58am) Added Fees Declaration Form
-   (28/may 01:20pm) Contact Form fixed
-   (03/jun 04:15pm) Performance Reports can be added
-   (05/jun 10:40pm) Approval to monthly student performance reports.
-   (07/jun 08:20pm) Timezone switched to UTC(look out for bugs), Made admission year readonly, added future year for select year
-   (14/jun 03:56pm) Added Program directly in syllabus Screen
-   (14/jun 11:59pm) Second page of print is not visible Declaration, Declaration Button on Admission List Screen
-   (15/jun 11:35am) Timezone issues fixed, Fixed Division Attendance not scoping based on school
-   (15/jun 05:20pm) Added Login and Error API added
-   (16/jun 04:25pm) Added Attendance API
-   (16/jun 10:40pm) Added Classwork API
-   (17/jun 00:05am) Added Logout API and migrations for it
-   (17/jun 05:10pm) Added Fees API, added id in classwork api response
-   (17/jun 10:55pm) Added Monthly present percentage to Attendance API, Added parents to syllabus topics/subtopics, Added invoice no, total fees, etc to Fees API
-   (17/jun 11:35pm) Added Parent Login Lock reset
-   (18/jun 12:40pm) Homework facility and automatic deletion of pics older than 15 days
-   (03/jul 10:40am) Added version update and homework api
-   (06/jul 11:25pm) Fixed mark syllabus first time error bug, added pending approval state after marking syllabus, fixed attendance date, Program Filter for book selection, fixed gapping for book button in teacher subject screen.
-   (07/jul 11:20am) Added student data export with images as zip
-   (08/jul 10:50am) Holiday List: Manage/View Holiday List, Holiday API
-   (17/jul 06:15pm) Gallery: Manage/View Albums List, Gallery API
-   (21/jul 12:05pm) Notice Board: Manage/View, API
-   (23/sep 09:00pm) Messages: Model, migration
-   (10/nov 04:20pm) Messages: Chat List UI
- 2022
-   (26/jan 07:13pm) Messages: Chat window for teacher
-   (26/jan 07:13pm) Messages: Chat API
-   (26/jan 08:05pm) Login API returns teacher data
-   (30/jan 05:40pm) Observation API added

## Admin Dashboard

-   (17/apr 12:50pm) **Exports**
    -   (17/apr 12:10am) **User**
    -   (17/apr 12:50pm) **School**
    -   (17/apr 12:50pm) **Enquiry**
    -   (17/apr 12:50pm) **Admission Export**
    -   (17/apr 12:50pm) **Fees**
    -   (17/apr 12:50pm) **Receipts**

## Changes to DONE

-   **Add working year**: Changes in all the files following academic year scope and in helper

    -   Admission
    -   Enquiry
    -   Fees
    -   Receipt
    -   Receipt Edit Screen

-   (7/apr 12:22pm) **School code**: Max 3 char school code for use in Student PRN number Invoicing and receipt searching

    -   add in the school migration code (review the migrations)
    -   School Edit and List Layout Screen
    -   Unique validation

-   (9/apr 11:00am) **Student PRN number** unique per student only for that school (format SCHOOL CODE\STUDENT CODE\ACADEMIC YEAR, ex. WLS/0001/2021 Add this in Admission Form

    -   Student migration - code column
    -   Edit and List Layout and validation

-   (9/apr 11:00am) **Fees Rate Card**: validation no need for all the fees to be added all time make sure in DB fields are nullable

-   (9/Apr 05:15pm) **Receipt Print layout**

    -   (DONE) add (sum of (in digits) &lt;amount&gt; on account of &lt;for&gt; in words &lt;amount&gt; only)
    -   (DONE) Add student PRN between receipt and date
    -   (DONE) Make school details on top left more obvious
    -   (DONE) Add bank name after cheque number
    -   (DISCARDED) Invoice No will contain the school code

-   (10/apr 02:41pm) **Fees Receipt Generation**: Misc receipts generation for events and stuff like that, Make sure to make on Behalf on section readonly in student receipts, Also add it to the menu.

    -   (DONE) Menu option (Keep get param empty)
    -   (DONE) Change the ReceiptEditLayout
    -   (DONE) Add New ReceiptScreen with Old ReceiptListLayout displaying all receipts not showing school fees
    -   (DONE) Add ability to print those receipts

-   (10/apr 05:13pm) **Invoice Print**

    -   Make InvoicePrintScreen
    -   Copy and Modify the receipt layout

-   (11/apr 2:14pm) **Added cancel for the receipts**

    -   Add Soft Deletes

-   (17/apr 4:30pm) **User Management for Schools**

-   **(Task) Make layout more colorful**

-   **Kit Stock Management**

    -   (18/apr 3:43pm) Model
        -   playgroup_total
        -   playgroup_current
        -   nursery_total
        -   nursery_current
        -   junior_kg_total
        -   junior_kg_current
        -   senior_kg_total
        -   senior_kg_current
    -   (18/apr 3:43pm) Ability to assign kit to the student
    -   (18/apr 7:52pm) Validations before assigning kit and added field in admission reports for both user and admin
    -   (18/apr 8:22pm) Kit Stock report for Admin

-   (12/apr 04:27pm) **Individual Student Receipt Report Export** (Excel, PDF)
-   (13/apr 11:17am) **(Feature) Multiple Center Head**

-   **Installments reminder option per month basis**

    -   (14/apr 08:40am) Installment Model
        -   month
        -   amount
        -   due_amount
        -   admission_id
        -   school_id
    -   (14/apr 8:40am) Installment option after the admission form
    -   (14/apr 12:48pm) See installments in student Receipts (Shool Fees)
    -   (14/apr 12:48pm) School Fees auto deduction in installment
    -   (15/apr 5:08pm) Widget on dashboard for current months pending due.

-   (14/apr 07:25pm) **Receipt canceled must be approved by owner (On Dashboard)**

    -   Approval Model
        -   model_id
        -   model_class
        -   approved_at
        -   school_id

-   (14/apr 09:05pm) **Deleted receipts should revert changes in installments**

-   (15/apr 5:08pm) **Admin and School Dashboard separation**

-   (16/apr 06:20pm) **Graduation logic**

    -   Button for graduate in admission actions
    -   Readonly: Name, DOB, Academic Year, Program
    -   If retained keep the programme same
    -   If not retained then set programme to next
    -   Make sure to create new admission with old student attached
    -   Make sure to redirect to installments

-   **Add new fields for admission and enquiry from rudresh sir**

## Reports -

Have ability to export these reports as excel or pdf

### Reports in account section

-   (11/apr 12:30pm) **Pay Due Report**: (Dropdown filter programme or all)

    -   PRN
    -   Student Name
    -   Father Name
    -   Program Name
    -   Discount Applicable
    -   Invoice Number
    -   Admission Date
    -   Invoice Amount
    -   Amount Received
    -   Due Amount

-   (11/apr 2:38pm) **Canceled Logs**: Add ability to cancel receipts and Reports for canceled one. (Excel, PDF)

    -   Student PRN
    -   Student Name
    -   Receipt Number
    -   Amount in Rs
    -   Cancellation Date

-   (11/apr 5:05pm) **Online Collection reports**: Report containing all the online payments done (Date Range Filter) (Excel, PDF)

    -   Student PRN
    -   Student Name
    -   Receipt Number
    -   Transaction ID
    -   Payment Date
    -   Amount

-   (11/apr 5:56pm) **Daily Collection reports**: (Date Range and Programme Filter) (Excel, PDF)

    -   Receipt No
    -   Cash
    -   Cheque
    -   Online

### Reports in Reports section

-   (11/apr 06:42pm) **Admission Report** (Program and Batch Filter) (Excel)

    -   State
    -   City
    -   Program
    -   Invoice Number
    -   Student name
    -   Admission Status - (New or Graduate)
    -   Father name
    -   Fathers Occupation
    -   Father contact no
    -   Father Email ID
    -   Mother name
    -   Mothers Occupation
    -   Mother contact no
    -   Mother Email ID
    -   Date of Birth
    -   Gender
    -   Admission date: Created At
    -   Address
    -   Batch
    -   Transport
    -   Date of conversion: Admission Date
    -   Previous Schooling

-   (12/apr 11:52am) **Enquiry Report** (Excel, PDF)

    -   Program Name
    -   Converted
    -   Not Converted
    -   Total

## Small Changes

-   (DONE) Slider Images
-   (DONE) Copyright Wonder Learning India Pvt. Ltd.
-   (DONE) Remove dummy client logos
-   (DONE) Remove call today from bottom of home page
-   (14/apr 10:03pm) Image for login background
-   (13/apr 9:07am) Change Cancel option in receipt from cancel to Delete
-   (13/apr 9:07am) Daily Collection Change column title Bank - Cheque
-   (14/apr 7:25pm) Designed by instead of made by
-   (28/may 08:58am) Admission cum/Declaration form with Photo
-   (14/apr 10:18pm) 'Name' to 'Student Name' and 'S/O' to 'Parent Name' InvoicePrintScreen
-   (14/apr 10:18pm) 'Admitted to' instead of Programme in InvoicePrintScreen and Admission Cum/Decl.
-   (14/apr 10:18pm) Nav Bg changed

<hr>

## Teacher Module

### Admin Panel Features

-   Admin should have an ability to (add/edit/delete) following:<br>
    Subjects > Books > Chapters > Topics > Sub Topics This also represents how these modules related to each other chapters contains topics and books contains chapter so on.

    -   Syllabus: Handled using Nested Set Package
        -   (27/apr 5:48pm) Admin Screen for syllabus: adding, updating, deleting using vue components
    -   (1/may 1:02pm) Subjects can be assigned under a programme
    -   (1/may 1:25pm) ProgramSubjects Association List and Delete options added

-   (DISCARDED) Ability to add academic year calendar with assigning of each topic on particular

### Center Head/Owner Panel Features

-   (28/apr 11:24pm) Divisions facility (Center head will be able to create Divisions for student Like A, B, etc.)
    -   title
    -   program
    -   teacher_id
    -   school_id
-   (28/apr 11:24pm) Center Head will assign a Program (PG/NUR/LKG/UKG) and division to a teacher (Teacher can have multiple subjects and multiple divisions assigned to them though subject would only have a single teacher).
-   (29/apr 01:25pm) Ability to assign division to the student
-   (06/may 06:30pm) Approval to Daily Teaching (Taught) syllabus.
-   (05/jun 10:40pm) Approval to monthly student performance reports.
    -   PerformanceReportApprovalScreen: under reports
        -   select division and month and show checkboxes
        -   set approved_at to date
-   Can see Student attendance and performance report an export excel if needed.

### Teacher Panel Features

-   Dashboard for teacher
-   (29/apr 9:35pm) Teachers will be able to see the list of all students under their divisions
-   They can mark attendance for students everyday
    -   (14/may 2:05pm) Division Attendance
        -   division_id
        -   date_at
    -   (14/may 2:05pm) Absent
        -   student_id
        -   division_attendance_id
    -   Attendance Screen
        -   (14/may 2:05pm) List and Add Attendance
        -   (19/may 6:37pm) Attendance Report
-   They will see entire syllabus for the subject they have been assigned
    -   (1/may 11:00pm) Subjects list screen for teacher with all the books as options
    -   (2/may 3:11pm) Clicking on book reveals syllabus
-   They can mark a Topic/Sub topic as finished on that particular day which then will be sent to center head for an approval.
    -   (2/may 03:11pm) Submit mark request and validate
    -   (6/may 06:30pm) Approval request to school admin (Changes required specified below)
        -   Method to approvals table
        -   Changes in delete of ReceiptListScreen
        -   Approval Service
        -   Changes in PlatformScreen
    -   (07/may 04:32pm) Reflection of syllabus taught in book screen
-   End of month performance report. This needs to be approved by center head before this can be seen by parents.
    -   PerformanceReportListScreen (Month and Division Filter)
    -   (03/jun 04:15pm) PerformanceReportEditScreen
        -   admission_id
        -   division_id
        -   performance
        -   date_at
-   This report then can be converted to final report for entire year forming a report card for that student which then can be seen from parents app.
-   Teachers will be able to see old attendance of students in their batch and get excel report if needed
-   Teachers will be able to see the performance report of their student and export it to excel if needed

### Notes for me

-   Thought on divisions implementation
    -   Store division name directly on admission table and in
    -   batches table only store school id

### Mobile App Features

#### App and API

**On Error API should return error message**

-   (15/jun 05:20pm) Error Response:

```json
{
    "error": "You are already logged in on another device"
}
```

-   (15/jun 05:20pm) Login:
    -   Login with any parent contact and PRN number
    -   `/login?contact=<contact>&prn=<prn>`
    -   Success: Student Data, School Data
-   (17/jun 00:05am) Logout: Logout with parent contact and student-id
-   Dashboard:
    -   Student Picture with name and buttons to all the screens ex, attendance, observations, etc
-   (16/jun 04:25pm) Attendance:
    -   Calendar Screen with monthly attendance with dates student is present marked green and red when they were absent if no class took place on that day it wil be white with present/absent percentage
    -   `/attendances/<student-id>`
    -   Success: Student Attendance Data
-   Observations (Performance Reports):
    -   Monthly observation reports filled by teachers can be seen here
-   (16/jun 10:40pm) Classwork (Syllabus Completion Status):
    -   What topics has been taught to this date with search feature
    -   Success:
-   Homework:
    -   Check the assigned homework to students divisions
-   Notice Board:
    -   Teachers/ School sent notices to particular students from a division to be seen here
    -   `/notices/<student-id>/<month:06-2021>`
    -   Success: List of Notices
-   (17/jun 05:10pm) Fees:
    -   View and download invoices and receipts and check remaining due amount to pay
    -   `/fees/<student-id>`
    -   Success: Receipt and Invoice Data
-   Profile:
    -   Students data can be viewed here
    -   `/student/<student-id>`
    -   Success: Student Data
-   Activities:
    -   Year wise activities/events school will take can be seen here
    -   `/activities`
-   Messages:
    -   Chat between division teacher and parents to raise a query or notify
    -   GET `chats/<student-id>`
    -   Success: List of Messages
    -   POST `chats/<student-id>`, BODY Params: `message`
    -   Success: List of Messages
-   Gallery:
    -   Gallery of images (In discussion)
    -   `/gallery`
-   Holiday List:
    -   View holidays added by school in list format
    -   `/holidays/<school-id>`
    -   Success: List of holidays

## School Panels

-   (17/jun 11:35pm) Login Lock Reset: As students account can only be logged in once if needed to login on other device school/teacher can reset lock from previous login so new login can be done
-   Observation: Ability to add monthly observations reports by teacher and then approved by center-head or owner then can be seen by parents inside the app
-   (18/jun 12:40pm) Homework: Ability to assign homework to all the students of a division
-   (21/jul 12:05pm) Notice Board: Ability to create notices for divisions and send them to all the parents of students in that division
-   Activities: Add/Manage custom activities for center-head/owner, which then can be seen by parents inside the app:
-   (26/jan) Messages: Chat for teachers between them and parents
-   (17/jul 06:15pm) Gallery: Upload and manage gallery for images
-   (08/jul 10:50am) Holiday List: Manage/View Holiday List which can be seen by parents
-   (17/jun 12:40pm) Automatic delete of pics older than 15 days