# Tasks (06-04-2021, Due date (10-04-2021)

## Notes

```
1) Add fields modified in migrations to the Models $fillable
 - School Done

```

-   **Add working year**: Changes in all the files following academic year scope and in helper

    -   Admission
    -   Enquiry
    -   Fees
    -   Receipt
    -   Receipt Edit Screen

-   **School code**: Max 3 char school code for use in Student PRN number Invoicing and receipt searching

    -   add in the school migration code (review the migrations)
    -   School Edit and List Layout Screen
    -   Unique validation

-   **Student PRN number** unique per student only for that school (format SCHOOL CODE\STUDENT CODE\ACADEMIC YEAR, ex. WLS/0001/2021 Add this in Admission Form

    -   Student migration - code column
    -   Edit and List Layout and validation

-   **Fees Rate Card**: validation no need for all the fees to be added all time make sure in DB fields are nullable

-   **Fees Receipt Generation**: Misc receipts generation for events and stuff like that, Make sure to make On Behalf on section readonly in student receipts, Also add it to the menu

-   **Receipt Print layout** also add image for login background

    -   add (sum of (in digits) &lt;amount&gt; on account of &lt;for&gt; in words &lt;amount&gt; only)
    -   Add student PRN between receipt and date
    -   Make school details on top left more obvious
    -   Add bank name after cheque number
    -   Invoice No will contain the school code

-   **Invoice Print**

    -   Check the invoice format for epms for invoice print

-   **User Management for Schools**
-   **Make layout more colorful**

-   ?(Need thinking and work) **Inventory & Stocks**: Add ability to manage inventory and stocks
    -   Item Name
    -   Price
    -   Available Units

## Reports -

Have ability to export these reports as excel or pdf

### Reports in account section

-   **Pay Due Report**: (Dropdown filter programme or all)
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
-   **Canceled Logs**: Add ability to cancel receipts and reports. (Excel, PDF)
    -   Student PRN
    -   Student Name
    -   Receipt Number
    -   Amount in Rs
    -   Cancellation Date
-   **Online Collection reports**: Report containing all the online payments done (Date Range Filter) (Excel, PDF)
    -   Student PRN
    -   Student Name
    -   Receipt Number
    -   Transaction ID
    -   Payment Date
    -   Amount
-   **Daily Collection reports**: (Date Range and Programme Filter) (Excel, PDF)

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

-   Slider Images
-   Copyright Wonder Learning India Pvt. Ltd.
-   Remove dummy client logos
-   Remove call today from bottom of home page
