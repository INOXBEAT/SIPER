<?php

require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class LoginTest extends TestCase
{
    private $client;
    private $baseUrl = 'http://localhost/sistema/';  # URL base del proyecto

    public function setUp(): void
    {
        $this->client = new Client(['base_uri' => $this->baseUrl]);
    }

    public function testLoginWithValidCredentials()
    {
        $response = $this->client->post('index.php', [
            'form_params' => [
                'usuario' => 'admin',  #usuario existente en base de datos
                'password' => 'admin',  #contraseña correcta
            ],
        ]);

        $this->assertEquals(302, $response->getStatusCode(), "Error: No hubo redirección cuando se esperaba.");

    if ($response->getStatusCode() == 302) {
        $this->assertTrue($response->hasHeader('Location'), "Error: No se encontró el encabezado 'Location'.");
        $this->assertStringContainsString('/main.php', $response->getHeader('Location')[0],
        "Error: La redirección no fue a 'main.php'.");
    } else {
        echo "Cuerpo de la respuesta: \n";
        echo (string) $response->getBody();
    
    }
}

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->client->post('index.php', [
            'form_params' => [
                'usuario' => 'administrador',
                'password' => 'administrador',
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('USUARIO O CONTRASEÑA INVÁLIDO', (string) $response->getBody());
    }

    public function testLoginWithoutCredentials()
    {
        $response = $this->client->post('index.php', [
            'form_params' => [
                'usuario' => '',
                'password' => '',
            ],
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('USUARIO O CONTRASEÑA INVÁLIDO', (string) $response->getBody());
    }
}
