# Schools/Branch CMS - Main Server Website

## Entities

### Students Table

```
name
dob_at
father_name
father_contact
father_occupation
father_email
father_organization_name
mother_name
mother_contact
mother_occupation
mother_email
mother_organization_name
previous_school
siblings
address
city
state
postal_code
nationality
```

### Enquiry Table

```
name
gender
dob_at
enquirer_name
enquirer_email
enquirer_contact
locality
reference
follow_up_at
student_id
```

### Admission Table

```
student_id
academic_year
admission_at
program -> Playgroup, Nursery, Junior KG, Senior KG
fees_installments -> 1..12
discount
batch
is_transportation_required
```

### Fees

```
title
playgroup
playgroup_total
nursery
nursery_total
junior_kg
junior_kg_total
senior_kg
senior_kg_total
```

### Receipt

```
invoice_no
amount
type
bank_name
bank_branch
transaction_no
paid_at
student_id
school_id
```
