<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 6/10/2022
 * Time: 6:51 PM
 */

/*

POST /api/v1/search HTTP/3
Host: alsoasked.com
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:101.0) Gecko/20100101 Firefox/101.0
Accept: application/json
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate, br
Referer: https://alsoasked.com/
X-XSRF-TOKEN: eyJpdiI6IkdudEthYzBmWm5uWmhwTDFaRDVlY1E9PSIsInZhbHVlIjoiZDJtVmhpN3NwQ0hibWd3elRscS9Md29aSHVKVkI1ekJRS3VzcDJrNmtnNXBhS1lGTDNuRm9zdlB0SkgxcHd4TmprZmUvc1Q1eThzL2diMkIzVDdIb3o3N0ZTY1FleEN4SU5oRXlvWm50RkQ1WlBMOVhucFhHc2pLMDhLWWFJbFoiLCJtYWMiOiIwNmU1YjE5N2IzY2Q3MjhjZTgxZjY0MmM3Y2JmYmQxMzY1ODBkM2ViZDhkMTVmODBhYzljMzc1ZDhkZDIyNzBlIiwidGFnIjoiIn0=
Content-Type: application/json
Origin: https://alsoasked.com
Content-Length: 69
Alt-Used: alsoasked.com
Connection: keep-alive
Cookie: XSRF-TOKEN=eyJpdiI6IkdudEthYzBmWm5uWmhwTDFaRDVlY1E9PSIsInZhbHVlIjoiZDJtVmhpN3NwQ0hibWd3elRscS9Md29aSHVKVkI1ekJRS3VzcDJrNmtnNXBhS1lGTDNuRm9zdlB0SkgxcHd4TmprZmUvc1Q1eThzL2diMkIzVDdIb3o3N0ZTY1FleEN4SU5oRXlvWm50RkQ1WlBMOVhucFhHc2pLMDhLWWFJbFoiLCJtYWMiOiIwNmU1YjE5N2IzY2Q3MjhjZTgxZjY0MmM3Y2JmYmQxMzY1ODBkM2ViZDhkMTVmODBhYzljMzc1ZDhkZDIyNzBlIiwidGFnIjoiIn0%3D; alsoasked_session=eyJpdiI6ImZYaDFCWVRDVDBiaFE2MnlJcHM2bFE9PSIsInZhbHVlIjoiUXhSL0xiNkc4cHVqZzFXRW1Fc1ZQdEQvRHkvaStMcWRveFRBMTFnVTg0bHUrSEV1bTEydEc1VEtiVW5HNG8xZ2lLTjBJZ2ZaRGlmbUFJYmxCeWxPS0NMQWpYYWtMcUFCZ2RKMVpQSk1GY21kZFRMaVJxSkt6dFVNQ3NlWG1XY3oiLCJtYWMiOiI5OWM4MWFhYTczODY4YzBmNjg3NWU3Yzg4MjU3ZmI5ZmI2MDU0MGRjYWI0MmUxZDkzMzNhMzA0OTE0NDZkYjU2IiwidGFnIjoiIn0%3D; __cf_bm=jm6Dd_f0aMpB82koOq95EhpUWTNc64rxQ5HcsmIrVQc-1654865109-0-ARxa9gYaOe69Fy67U8YEivo3ovCRaVtYmv7IS31AAjc1QJrV4+NF/DtZ6m6f97gegyFatgAPKFaOUHqPPiIYnMJhYVQpJeKzyMwFmqlbTBFk6e2bPD6Khd4jIvTGcHU8tA==; _ga=GA1.2.1977009446.1654865112; _gid=GA1.2.1926520826.1654865112; _iub_cs-54390361=%7B%22timestamp%22%3A%222022-06-10T12%3A45%3A10.480Z%22%2C%22version%22%3A%221.38.0%22%2C%22purposes%22%3A%7B%221%22%3Atrue%2C%222%22%3Atrue%2C%223%22%3Atrue%2C%224%22%3Atrue%2C%225%22%3Atrue%7D%2C%22id%22%3A54390361%2C%22cons%22%3A%7B%22rand%22%3A%225f34aa%22%7D%7D; _clck=1u898ld|1|f27|0; intercom-id-g4so60i1=bf656cab-bb9e-4dd1-8ac3-432818e76374; intercom-session-g4so60i1=; _clsk=c3xt7y|1654865169150|5|1|a.clarity.ms/collect; bulk-search-tooltip-dismissed=1
Sec-Fetch-Dest: empty
Sec-Fetch-Mode: cors
Sec-Fetch-Site: same-origin
TE: trailers


 */

// https://alsoasked.com/api/v1/search   POST // {"terms":["why acid rain"],"language":"en","region":"gb","depth":"2"}
// RESPONSE {"id":"aroDMR0qJ9b3YXMnrkNP5VKgWnOEvGyx","terms":["why acid rain"],"region":"gb","language":"en","status":"queueing","remaining":0,"is_deleted":false,"depth":2,"date":"2022-06-10T12:46:33+00:00"}
// GENERATED  https://alsoasked.com/api/v1/search/aroDMR0qJ9b3YXMnrkNP5VKgWnOEvGyx
