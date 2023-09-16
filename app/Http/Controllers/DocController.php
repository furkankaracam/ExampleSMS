<?php

namespace App\Http\Controllers;

/**
 * @SWG\Swagger(
 *     @OA\Info(
 *          version="1.0.0",
 *          title="ExampleSMS API",
 *          description="ExampleSMS firması müşterilerine sms gönderim hizmeti sunan bir
firmadır. Bu müşterilerin kendilerine ait kullanıcı adları ve
şifreleri vardır. Müşteriler restful api kullanarak sms gönderimi
yapabilir, sms raporlarını(kayıtlarını) görebilir, sms rapor
detayını görebilir ve bu raporları tarih filtresine göre
filtreleyebilir."
 *     ),
 *       @OA\PathItem (
 *          path = "/api/"
 *     )
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */

class DocController extends Controller
{

}
