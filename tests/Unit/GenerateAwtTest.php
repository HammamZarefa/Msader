<?php

namespace Tests\Feature;

use Firebase\JWT\JWT;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateAwtTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $privateKey = "MIIEoQIBAAKCAQBFkV3ib2SCwM/DT1yRK8bPYRiFTqCzJ/jC6RctFAcktyKoLAvg
lS4l3u/NJsowE/UNz3gnXXYt5hEN8VvAbqEyiEc2CBvQvN3HHAtvNLVCTYSKyfh/
DXRqE6Nj6ONJBOz75hanOT3RY/pTk2ykpWGoud/7JjdCr1DCHIkyDMQuVFZ7oV6U
UbrA8mFF2fwYKum/wC1wb8Js+Bc/Q+llq/CoAdYvDsZ0wMN4DjMsfgYf7y97lc9a
s3VOzRrQDE4LgGL8815C8G0cherajCdR8KGWpDJ7tcbpMhuPvA7oRCY7nWp/4xvd
tEdTABIyhKfin8NKD1D6rBSNvTIThB/IqSczAgMBAAECggEAHx9MWAurdI9boy2y
5MMn2wi+Fo05eUzNji0HEESgeX1whLnHyn4SuiCFOUs8MswK2lXRlBLM1vXQ9WLf
wDP964RqDzMLdpO3x+a0+tgiqvnQ7OI0SGq1hOsqMn0yiS0p8/tYcRE7pZxLle4j
MXlHOluFZ28OU8fooh5wBjMN5QegiR2Oy+/ZoaJAk+naS0B1D1bSQ9pz5qW2DEdC
W8nTn7c1PCYVrJJtr1lVTR5lIG077O+0oXywjdINPHh6SpdLwR17UyRwdzFtj9gs
BCngv6AegyQ57BHtNGnuGhdaa0a3tJn3/RkHW2g7YejN96Um2NqmzJ4FCYluDw4o
Q0l9sQKBgQCHrLnniVCnS3kWoccJzcKoPSC9BoxTKizvWhfsWwBzAWR6qBa+BE5l
GjflEY0AjDMPrTSOJvSxDQXp8RyW7GOwks1r58I9sI55O94pirQ6qFI3QLBG8ur9
v4MgclyN8O+wJ9Wa66L/4g9wYtkGretQ+pTREYJzPbRYGN11fJkXCQKBgQCDQ+N1
P6rNrlEvjeInHZTqPYOCqBpkoAGSzeQPqmcuLixc9MGnjGDH80S+oiSvJSfOp1yj
ta0p2kleceZAndGuZz0SnR+AkTCnruNBQutLqqtfqI+Y6gdddpwDMqIGuQSUp+WT
9BxLVyIUo3GMcDfO6Iv5eAwPNi9lYfO1pOz/WwKBgCwAif6c20qWwLvlVg9I63Py
91Y29HXYfOBX4OBoFzo1XmglcdLIxMAng69IROnDjp/r9dqQqdVuOtfHuhT8r8xJ
oFP5w1aMl3icQQ5KDO/lPVzsHv+zsyD+5sE0Ne5XEPWZxb5L4/6HS6iQdoCjEWmf
C3rO6fcEMSRNVC3Rbjk5AoGAQmYR5dpZzQcTXCm6Ly0giciqAGqGR0ZE5Xyuk1oQ
LWT/3dmVJ+qzfhFJQeEFC2+RDlDMZKdeu6AGovackS0DxuPEGelO6RsIcJnfrMBs
A2+GlrHOSXyAUz/PNTLkkOAAOC4hzFCcC2Q9AhGXO4H8SPaK75tRBlTTbsY4oDaY
B6cCgYBLijYHzikzHlIXnEOIGiHqkjrJnZRVxLuXrkVpRfG4Yj4qzYackuqWbASQ
i2GyNkQcs9jAqK4Hfgaexi91j2hMXxhdrRm6kGxnJUs/utNDFgmrpmtrZkEx690P
4TimLGx6oErRAIt73+oktSXxG9AOjYqGn1kc6s7DLlefO2gSCA==";

        $header = [    "alg" => "RS256",    "typ" => "JWT" ,"kid" => "40ab7a24-1daf-4769-98e1-3f937d14ee6d"];

        $payload = [
            "iss"=>"pandago:sg:70908f4a-982b-4417-af93-8b367defd458",
  "sub"=>"pandago:sg:70908f4a-982b-4417-af93-8b367defd458",
  "jti"=>"caa56777-4e88-4c59-be70-3ae513fd2e00",
  "exp"=>time(),
  "aud"=>"https://sts.deliveryhero.io"
        ];

        $jwt = JWT::encode($header, $payload, $privateKey, 'RS256');
        $this->assertEquals(1,2);
        dd($jwt);
    }
}
