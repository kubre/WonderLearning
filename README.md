# Tasks (06-04-2021, Due date (10-04-2021)

## Notes

```
1) Add fields modified in migrations to the Models $fillable
 - School Done
2) Menu nav bug cause of receipt for student and receipt generation having same route name

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
-   **Make layout more colorful**

-   ?(Need thinking and work) **Inventory & Stocks**: Add ability to manage inventory and stocks
    -   Item Name
    -   Price
    -   Available Units

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

    In this report make sure to add amount only in column in which payment was done at the end add a total column for individual (Total for all?)

### Reports in Reports section

-   **Admission Report** (Program and Batch Filter) (Excel, PDF)
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
-   **Enquiry Report** (Excel, PDF)
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
