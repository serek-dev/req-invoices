# Recruitment Task 🧑‍💻👩‍💻

### Invoice module with approve and reject system as a part of a bigger enterprise system. Approval module exists and you should use it. It is Backend task, no Frontend is needed.
---
Please create your own repository and make it public or invite us to check it.


<table>
<tr>
<td>

- Invoice contains:
  - Invoice number
  - Invoice date
  - Due date
  - Company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
  - Billed company
    - Name 
    - Street Address
    - City
    - Zip code
    - Phone
    - Email address
  - Products
    - Name
    - Quantity
    - Unit Price	
    - Total
  - Total price
</td>
<td>
Image just for visualization
<img src="https://templates.invoicehome.com/invoice-template-us-classic-white-750px.png" style="width: auto"; height:100%" />
</td>
</tr>
</table>

### TO DO:
Simple Invoice module which is approving or rejecting single invoice using information from existing approval module which tells if the given resource is approvable / rejectable. Only 3 endpoints are required:
```
  - Show Invoice data, like in the list above
  - Approve Invoice
  - Reject Invoice
```
* In this task you must save only invoices so don’t write repositories for every model/ entity.

* You should be able to approve or reject each invoice just once (if invoice is approved you cannot reject it and vice versa.

* You can assume that product quantity is integer and only currency is USD.

* Proper seeder is located in Invoice module and it’s named DatabaseSeeder

* In .env.example proper connection to database is established.

* Using proper DDD structure is preferred (with elements like entity, value object, repository, mapper / proxy, DTO) but not mandatory.
Unit tests in plus.

* Docker is in docker catalog and you need only do 
  ```
  ./start.sh
  ``` 
  to make everything work

  docker container is in docker folder. To connect with it just:
  ```
  docker compose exec workspace bash
  ``` 

# Solution

## Approval module

```bash
./start.sh
```

Start the project, db should be seeded, and the first two invoices should be in draft status.
It should be possible to use these two endpoints in order to approve or reject it.

I've divided all this logic into two paths. Shape of existing DTO was a little bit not clear to me
so I have adjusted it to my assumptions.

```bash
curl -X PATCH http://localhost/api/approvals/0e62f10d-a668-46ed-9520-5393d5094889/approve -H 'Content-Type: application/json' -H 'Accept: application/json'
```

## Rejection

```bash
curl -X PATCH http://localhost/api/approvals/1594d999-28ad-4699-9b28-4236ea48aa1f/reject -H 'Content-Type: application/json' -H 'Accept: application/json'
```

Request is validating that provided route {id} exists, if not, the following response blows up the mind:

```bash
curl -X PATCH http://localhost/api/approvals/i-am-not-even-uuid/reject -H 'Content-Type: application/json' -H 'Accept: application/json'
```

```json
{
  "message": "The selected id is invalid.",
  "errors": {
    "id": [
      "The selected id is invalid."
    ]
  }
}
```

On consecutive calls with existing uuids (non-draft), ugly error will be thrown, normally I'd to handle it at
global handling scope.

Once everything is fine, invoices should change statuses correspondingly:

```mysql
select id, status
from invoices
where id in ('0e62f10d-a668-46ed-9520-5393d5094889', '1594d999-28ad-4699-9b28-4236ea48aa1f');
```

```text
0e62f10d-a668-46ed-9520-5393d5094889 | approved
1594d999-28ad-4699-9b28-4236ea48aa1f | rejected
```

## Show an invoice

I've decided do split write / read logic. Most of the cases it's a good idea, especially in the DDD approach, so we can
keep
domain entities thin and focused on domain logic. Projection can be whatever or a
combination of whatever (sql + hardcoded data etc).

```bash
curl -X GET http://localhost/api/invoices/1594d999-28ad-4699-9b28-4236ea48aa1f -H 'Content-Type: application/json' -H 'Accept: application/json'
```

Basic validation added as well.

## Optional

I also added unit tests and feature tests at the level of InvoiceFacade to test real integrations works, run on
started project:

```bash
docker compose exec workspace composer tests:unit
docker compose exec workspace composer tests:feature
```
