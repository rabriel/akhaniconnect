# VerifyNow API Documentation

South Africa's identity verification and compliance API. Verify IDs, screen for AML/PEP, and more.

## Base URL

```
https://www.verifynow.co.za/api/external
```

## Authentication

All API requests require an API key passed in the `x-api-key` header.

```bash
curl -X POST https://www.verifynow.co.za/api/external/verify \
  -H "x-api-key: vn_live_abc123..." \
  -H "Content-Type: application/json"
```

**Important:** Never expose your API key in client-side code. Make API calls from your server only.

## Credit System

API calls are billed via credits. Purchase upfront and they are deducted per successful verification.

### Pricing Tiers
| Tier | Price per Credit |
|------|------------------|
| Standard | R2.99 |
| High Volume / Enterprise | Contact us for custom pricing |

## Idempotency

Use the `Idempotency-Key` header to safely retry requests without duplicate charges. Required for production mode.

```bash
curl -X POST https://www.verifynow.co.za/api/external/verify \
  -H "x-api-key: vn_live_abc..." \
  -H "Idempotency-Key: unique-request-id-123" \
  -H "Content-Type: application/json" \
  -d '{"reportType":"home_affairs_id_photo","idNumber":"8001015009087","mode":"production"}'
```

## Optional ID Number Validation

For South African ID inputs, we recommend running the standard ID checksum in your application before sending a verification request. This optional pre-flight validation catches typing errors early and can help avoid unnecessary calls. It does not change endpoint paths, payload fields, or response formats.

## Sandbox Mode

Set `mode: "sandbox"` to test without using credits. Returns mock data.

---

## Enterprise Bundles

### POST /verify - KYC Bundle
**Credits:** Dynamic (Home Affairs ID Photo + Consumer Trace Lite)

One-call KYC lookup combining Home Affairs ID photo verification with Consumer Trace Lite contact and address data.
The prescribed reason is fixed to fraud prevention (FraudDetectionFraudPrev) for this bundle. Customers must have a lawful POPIA basis and must treat any Home Affairs photo or biometric output as special personal information.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| bundle | string | Yes | "kyc_bundle" |
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

---

## Identity Endpoints

### POST /verify - Home Affairs ID Photo
**Credits:** Dynamic

Get the official Home Affairs ID photo for a person.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| reportType | string | Yes | "home_affairs_id_photo" |
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

### POST /verify - SAID Verification
**Credits:** Dynamic

Basic ID number validation against Home Affairs. Returns core identity fields only; it does not return alive/deceased status. Use the dedicated Alive/Deceased Status checks when that field is required.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| reportType | string | Yes | "said_verification" |
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

**Example Response:**
```json
{
  "success": true,
  "requestId": "unique-request-id",
  "user_id": "11",
  "remainingCredits": 32,
  "mode": "production",
  "reportType": "said_verification",
  "input": {
    "idNumber": "9111060123086"
  },
  "results": {
    "said_verification": {
      "Status": "Success",
      "realTimeResults": {
        "Status": "ID Number Valid",
        "Verification": {
          "Firstnames": "NALEDI LERATO",
          "Lastname": "KHUMALO",
          "Dob": "1991-11-06",
          "Age": 34,
          "Gender": "Female",
          "Citizenship": "South African",
          "DateIssued": ""
        },
        "transaction_id": "19031247"
      },
      "transaction_id": "19031247",
      "meta": {
        "environment": "production",
        "timestamp": "2026-05-26T07:54:16.776Z"
      }
    }
  }
}
```

### POST /verify - Enhanced Alive/Death Status
**Credits:** Dynamic

Real-time South African ID number verification against Home Affairs records with detailed alive/death status fields where available. Use this when you need a live Home Affairs result for higher-assurance onboarding, deceased-status review, and identity status verification workflows.

**Returned fields may include:**
- ID number, submitted ID number, and Home Affairs ID number
- ID number match status
- ID book issued date, ID card indicator/date, and identity document type
- Blocked ID status
- First names, surname, date of birth, age, gender, citizenship, and country of birth
- Deceased status, deceased date, death place, and cause of death
- Marital status and marriage date
- ID photo where returned
- Transaction reference

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| reportType | string | Yes | "home_affairs_real_time_idv" |
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

**Example Response:**
```json
{
  "success": true,
  "requestId": "unique-request-id",
  "user_id": "11",
  "remainingCredits": 32,
  "mode": "production",
  "reportType": "home_affairs_real_time_idv",
  "input": {
    "idNumber": "7905011111118"
  },
  "results": {
    "home_affairs_real_time_idv": {
      "Status": "Success",
      "realTimeResults": {
        "idNumber": "7905011111118",
        "inputIdno": "7905011111118",
        "haIdno": "7905011111118",
        "idnoMatchStatus": "Matched",
        "haIdBookIssuedDate": "1994-08-01",
        "idCardInd": "No",
        "idCardDate": "",
        "identityDocumentType": "ID Book",
        "idBlocked": "NO",
        "IDPhoto": "base64_encoded_image_where_available",
        "firstNames": "JOHN",
        "surName": "DOE",
        "dob": "1979-05-01",
        "age": 47,
        "gender": "Male",
        "citizenship": "South African",
        "countryofBirth": "SOUTH AFRICA",
        "deceasedStatus": "Deceased",
        "deceasedDate": "1999-12-16",
        "deathPlace": "NELSPRUIT",
        "causeOfDeath": "NATURAL CAUSES",
        "maritalStatus": "MARRIED",
        "marriageDate": "1970-08-22"
      },
      "transaction_id": "19031248",
      "meta": {
        "environment": "production",
        "timestamp": "2026-05-26T07:54:16.776Z"
      }
    }
  }
}
```

### POST /id-enhanced - ID Photo Offline
**Credits:** Dynamic

Cached ID details and Home Affairs photo lookup. This is the public API endpoint for the dashboard flow at /verifynow?reportType=id-enhanced. Read the photo from `results.biometric_results.image_base_64`.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

---

## Consumer Data Endpoints

### POST /verify - Consumer Trace (All-in-One)
**Credits:** Dynamic

**This is your one-stop endpoint for consumer data.** A single API call returns ALL of the following:
- **AddressData**: Current and historical addresses (residential & postal)
- **EmploymentData**: Employment history with employer names
- **ContactData**: Phone numbers (cell and landline)
- **DefiniteMatchData**: ID verification details

No need to make separate calls for address, employment, or phone data.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

**Example Request:**
```json
{
  "reportType": "consumer_trace",
  "idNumber": "8803145123084",
  "mode": "production"
}
```

**Example Response:**
```json
{
  "success": true,
  "requestId": "idem-uuid",
  "remainingCredits": 65,
  "mode": "production",
  "reportType": "consumer_trace",
  "results": {
    "consumer_trace": {
      "Status": "Success",
      "id_number": "8803145123084",
      "full_name": "THABO JAMES MOKOENA",
      "gender": "Male",
      "date_of_birth": "1988-03-14",
      "addresses": [
        { "type": "RESIDENTIAL", "address_line_1": "14 OAK AVENUE, SANDTON, JOHANNESBURG, GAUTENG", "postal_code": "2196" }
      ],
      "contact_numbers": [
        { "type": "CELL", "number": "0821234567" }
      ],
      "transaction_id": "3443288",
      "meta": {
        "environment": "production",
        "timestamp": "2026-04-16T17:50:00Z"
      }
    }
  }
}
```

**Headers (Required for production):**
| Header | Description |
|--------|-------------|
| x-api-key | Your API key |
| Content-Type | application/json |
| Idempotency-Key | Unique request ID (UUID) - prevents duplicate charges |

### POST /verify - Phone Lookup (Reverse)
**Credits:** Dynamic

Reverse phone lookup - find out who owns a phone number. Use this when you have a phone number and want to find the owner. Requires Idempotency-Key header for production.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| reportType | string | Yes | "contact_enquiry" |
| contactNumber | string | Yes | 10-digit SA phone number starting with 0 |
| mode | string | Yes | "sandbox" or "production" |

**Example Request:**
```json
{
  "reportType": "contact_enquiry",
  "contactNumber": "0821234567",
  "mode": "production"
}
```

**Example Response:**
```json
{
  "success": true,
  "requestId": "idem-uuid",
  "remainingCredits": 65,
  "mode": "production",
  "results": {
    "contact_enquiry": {
      "Status": "Success",
      "Surname": "MOKOENA",
      "First_Name": "THABO JAMES",
      "Number_1": "0821234567",
      "transaction_id": "DX-12345",
      "meta": {
        "environment": "production",
        "timestamp": "2026-04-16T17:50:00Z"
      }
    }
  }
}
```

---

## Compliance Endpoints

### POST /aml-screening - AML/PEP Screening
**Credits:** Dynamic

Screen individuals or companies against global sanctions lists, PEP databases, and crime/adverse media records.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| name | string | Yes | Full name or business name to screen |
| entity | integer | Yes | Entity type: 0=Person, 1=Company, 2=Organization, 3=LegalEntity, 6=Airplane, 7=Vessel |
| country | string | Yes | 2-letter ISO country code (e.g., "za", "us", "gb") |
| dataset | string | Yes | Search scope: "all", "sanctions", "peps", or "crime" |
| mode | string | Yes | "sandbox" or "production" |

**Example Request:**
```bash
curl -X POST https://www.verifynow.co.za/api/external/aml-screening \
  -H "x-api-key: vn_live_abc123..." \
  -H "Content-Type: application/json" \
  -H "Idempotency-Key: unique-request-id" \
  -d '{"name":"John Doe","entity":0,"country":"za","dataset":"all","mode":"production"}'
```

### POST /bank-account-verification - Bank Account Verification
**Credits:** 6

Verify if a bank account belongs to a specific identity (Individual or Company). Returns real-time confirmation of account ownership and status.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| type | string | No | "Individual" or "Company" (defaults to Individual) |
| firstName | string | No | First name of the individual (Individual only) |
| surname | string | Yes | Surname (Individual) or Company Name (Company) |
| identityNumber | string | Yes | ID, Passport, or Registration number |
| identityType | string | Yes | "IDNumber", "PassportNumber", "CompanyRegNumber", etc. |
| bankAccountNumber | string | Yes | Bank account number to verify (7-13 digits) |
| bankBranchCode | string | Yes | 6-digit branch code (e.g. "250655") |
| bankAccountType | string | Yes | "Savings", "Current", "Transmission", etc. |
| mode | string | Yes | "sandbox" or "production" |

> [!NOTE]
> For **Company** verification, please leave the `firstName` parameter empty and provide the full company name in the `surname` field. Ensure `identityType` is set to `CompanyRegNumber`.

**Individual Example:**
```json
{
  "type": "Individual",
  "firstName": "John",
  "surname": "Doe",
  "identityNumber": "9001015000080",
  "identityType": "IDNumber",
  "bankAccountNumber": "123456789",
  "bankBranchCode": "250655",
  "bankAccountType": "Savings",
  "mode": "production"
}
```

**Company Example:**
```json
{
  "type": "Company",
  "surname": "Urban Luxury Brands",
  "identityNumber": "2007/013732/07",
  "identityType": "CompanyRegNumber",
  "bankAccountNumber": "62142892604",
  "bankBranchCode": "250741",
  "bankAccountType": "Current",
  "mode": "production"
}
```

---

## Business Verification

### POST /cipc - CIPC Company Match
**Credits:** Dynamic

Verify company registration with CIPC. Returns full details including directors, business status, auditors, and historical changes. Provide either `registration_number`, `vat_number`, or `sole_prop_id_number`.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| reportType | string | Yes | "cipc_company_match" |
| registration_number | string | No | SA company registration number (e.g. "2010/123456/07") |
| vat_number | string | No | SA VAT number |
| sole_prop_id_number | string | No | 13-digit SA ID number (for sole proprietors) |
| mode | string | Yes | "sandbox" or "production" |

### POST /cipc - CIPC Director Search
**Credits:** Dynamic

Find all companies a person is (or was) a director of, using their South African ID number.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| reportType | string | Yes | "cipc_director_search" |
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

---

## Face Match & Biometrics

### POST /facematch - Face Match (Home Affairs)
**Credits:** Dynamic

Compare a selfie against the official Home Affairs ID photo. Just send the selfie and ID number.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| bundle | string | Yes | "facematch" |
| selfie_image_base64 | string | Yes | Base64-encoded selfie image |
| id_number | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

### POST /facematch - Face Match (Standard)
**Credits:** Dynamic

Compare two photos for face similarity.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| bundle | string | Yes | "facematch_standard" |
| selfie_image_base64 | string | Yes | Base64-encoded selfie image |
| reference_image_base64 | string | Yes | Base64-encoded reference image |
| mode | string | Yes | "sandbox" or "production" |

### POST /facematch - Face Match + ID Verification
**Credits:** Dynamic

Combined face match plus SAID verification.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| bundle | string | Yes | "facematch_verified" |
| selfie_image_base64 | string | Yes | Base64-encoded selfie image |
| reference_image_base64 | string | Yes | Base64-encoded reference image |
| id_number | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

### POST /passive-liveness - Passive Liveness
**Credits:** Dynamic

Check if an image is a real person (not a photo of a photo, mask, or deepfake).

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| image_base64 | string | Yes | Base64-encoded image |
| mode | string | Yes | "sandbox" or "production" |

### Biometric Rate Limits

Face matching and liveness endpoints have specific rate limits:
- 60 requests per minute per API key
- 1,000 requests per hour per API key
- Image limit: 5 MB per image
- Request body limit: 4.5 MB total
- If sending JSON/base64, keep the combined raw images under about 3 MB because base64 adds roughly 33% overhead
- 10 concurrent requests per API key

---

## Document OCR

### POST /id-document-verify - ID Document OCR
**Credits:** 6

Extract data from ID documents using OCR. Supports ID cards, passports, and driver's licenses.

**Payload limits:** Each image must be under 5 MB. The total request body must stay below 4.5 MB. Multipart/form-data is recommended. If using JSON/base64, keep the combined raw images under about 3 MB total because base64 adds roughly 33% overhead.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| bundle | string | Yes | "id_document_verification" |
| front_image | file | Yes for multipart | Front image file (recommended) |
| back_image | file | No | Back image file (optional, multipart) |
| front_image_base64 | string | Yes for JSON | Base64-encoded front image |
| back_image_base64 | string | No | Base64-encoded back image (optional) |
| document_type | string | No | Hint for document type |
| issuing_country | string | No | 3-letter ISO country code |
| mode | string | Yes | "sandbox" or "production" |

---

## Vehicle Endpoints

### POST /vehicle - Vehicle Lookup
**Credits:** 10

Lookup vehicle details by registration number (license plate) or VIN.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| bundle | string | Yes | "vehicle_lookup" |
| registrationNumber | string | No | SA license plate (e.g., "ABC123GP") |
| vin | string | No | 17-character VIN |
| mode | string | Yes | "sandbox" or "production" |

---

## Utility Endpoints

### GET /health - Health Check
**Credits:** 0

Check if the API is operational. No authentication required.

**Example:**
```bash
curl https://www.verifynow.co.za/api/external/health
```

**Response:**
```json
{"status":"ok","timestamp":"2024-01-15T10:30:00.000Z","version":"1.0.0"}
```

### GET /my_credits - Check Credit Balance
**Credits:** 0

Check your current credit balance. Requires API key.

**Example:**
```bash
curl https://www.verifynow.co.za/api/external/my_credits \
  -H "x-api-key: vn_live_abc123..."
```

**Response:**
```json
{"available_credits":1000}
```

### POST /consumer-trace-lite - Consumer Trace Lite
**Credits:** 5

A faster, focused version of the consumer trace. Returns core identity status fields, including `MaritalStatus` and `Deceased`, plus essential contact details and address information in a flat structure. Use this endpoint for focused marital status checks and alive/deceased status checks.

**Parameters:**
| Name | Type | Required | Description |
|------|------|----------|-------------|
| idNumber | string | Yes | 13-digit SA ID number |
| mode | string | Yes | "sandbox" or "production" |

**Headers (Required for production):**
| Header | Description |
|--------|-------------|
| x-api-key | Your API key |
| Content-Type | application/json |
| Idempotency-Key | Unique request ID (UUID) - prevents duplicate charges |

**Example Request:**
```json
{
  "idNumber": "9103015257085",
  "mode": "production"
}
```

---

## Error Codes

| Code | Description |
|------|-------------|
| 200 | Success - request completed |
| 400 | Bad Request - invalid parameters |
| 401 | Unauthorized - invalid or missing API key |
| 402 | Payment Required - insufficient credits |
| 409 | Conflict - idempotency key reused with different payload |
| 429 | Too Many Requests - rate limit exceeded |
| 500 | Server Error - try again later |

**Error Response Format:**
```json
{
  "error": "Insufficient credits",
  "requiredCredits": 6,
  "availableCredits": 2
}
```

---

## Support

For API support, contact: support@verifynow.co.za
