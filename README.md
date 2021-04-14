# Tasks (06-04-2021, Due date (10-04-2021)

## Notes

```
1) Add fields modified in migrations to the Models $fillable
 - School Done
2) Menu nav bug cause of receipt for student and receipt generation having same route name
3) Implement graduation logic
3) (Fixed) Fees receipt generation failing
4) Canceling receipt restore installment amount.
```

## Dashboard

-   (9/apr 11:00am) Fees Rate Card

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
-   (11/apr 2:14pm) Added cancel for the receipts
-   (11/apr 2:38pm) Added Cancelled receipts logs reports, changed csv export name scheme
-   (11/apr 5:05pm) Online Collection reports added, custom filter layout added
-   (11/apr 5:56pm) Add Daily Collection, Minor tweaks other reports and filters
-   (11/apr 06:42pm) Admission Report and added batch filter in Program Selection
-   (12/apr 11:52am) Enquiry Report (Excel, PDF) now admission create will also save student_id in enquiry
-   (12/apr 4:27pm) Individual Student Receipt Report Export, some query optimizations
-   (13/apr 9:07am) Fixed Fees Receipt generation error on create as some students didn't had admission that year solved by using Admission instead of student Payment Due error on no data fixed, changed text cancel to delete for receipt action
-   (13/apr 11:17am) Print button is in warning style everywhere and fixed every model loading same data with multiple queries, Multiple Center Head
-   (14/apr 8:40am) Removed fees installments from admission moved to separate model, screen to add installment added
-   (14/apr 8:40am) Installment deduction while paying receipt, Installment tab in receipts

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

-   **User Management for Schools**

-   **(Task) Make layout more colorful**

-   ?(Need thinking and work) **Inventory & Stocks**: Add ability to manage inventory and stocks

    -   Item Name
    -   Price
    -   Available Units

-   (12/apr 4:27pm) **Individual Student Receipt Report Export** (Excel, PDF)
-   (13/apr 11:17am) **(Feature) Multiple Center Head**

-   **Installments reminder option per month basis**

    -   (14/apr 8:40am) Installment Model
        -   month
        -   amount
        -   due_amount
        -   admission_id
        -   school_id
    -   (14/apr 8:40am) Installment option after the admission form
    -   (14/apr 12:48pm) See installments in student Receipts (Shool Fees)
    -   (14/apr 12:48pm) School Fees auto deduction in installment
    -   Widget on dashboard for current months pending due.

-   **Add new fields for admission and enquiry from rudresh sir**

## Reports -

Have ability to export these reports as excel or pdf

### Reports in account section

-   (11/apr 12:30pm)**Pay Due Report**: (Dropdown filter programme or all)

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

-   ?(Need more thinking) **Inventory & Stocks Report**

## Small Changes

-   (DONE) Slider Images
-   (DONE) Copyright Wonder Learning India Pvt. Ltd.
-   (DONE) Remove dummy client logos
-   (DONE) Remove call today from bottom of home page
-   Image for login background
-   (13/apr 9:07am) Change Cancel option in receipt from cancel to Delete
-   (13/apr 9:07am) Daily Collection Change column title Bank - Cheque
-   Designed by instead of made by
-   Admission cum/Declaration form with Photo
-   Receipt canceled must be approved by owner (On Dashboard)
-   'Name' to 'Student Name' and 'S/O' to 'Parent Name' InvoicePrintScreen
-   'Admitted to' instead of Programme in InvoicePrintScreen and Admission Cum/Decl.
