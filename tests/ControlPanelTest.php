<?php
require_once 'vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class ControlPanelTest extends TestCase
{
    private $client;
    private $baseUrl = 'http://localhost/sistema/';

    public function setUp(): void
    {
        # Configura Guzzle para usar cookies y mantener sesiones
        $cookieJar = new CookieJar();
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'cookies' => $cookieJar,
        ]);
    }

    public function testAccessWithoutLogin()
    {
        $response = $this->client->get('controlpanel.php');

        if ($response->getStatusCode() != 302) {
            echo "Código de estado recibido: " . $response->getStatusCode() . "\n";
            echo "Cuerpo de la respuesta:\n" . (string) $response->getBody();
        }

        $this->assertEquals(302, $response->getStatusCode(), "El acceso sin autenticación debería redirigir al login");
    }


    public function testAccessWithAdminRole()
    {
        $response = $this->client->post('index.php', [
            'form_params' => [
                'usuario' => 'admin',  # Usuario administrador
                'password' => 'admin',  # Contraseña válida
            ],
        ]);

        $response = $this->client->get('controlpanel.php');

        $this->assertEquals(200, $response->getStatusCode());

        # Verifica que tiene acceso a secciones exclusivas de administrador
        $this->assertStringContainsString('PROVEEDORES', (string) $response->getBody());
        $this->assertStringContainsString('CONFIGURACIÓN', (string) $response->getBody());
    }

    public function testAccessWithLimitedRole()
    {
        # Simula inicio de sesión como usuario limitado
        $response = $this->client->post('index.php', [
            'form_params' => [
                'usuario' => 'user_limited',  # Usuario con rol limitado
                'password' => 'password',  # Contraseña válida
            ],
        ]);

        # Accede al panel de control
        $response = $this->client->get('controlpanel.php');

        # Debería ser exitoso (sin redirección)
        $this->assertEquals(200, $response->getStatusCode(), "El código de estado debería ser 200");

        # Verifica que NO tiene acceso a secciones exclusivas de administrador
        $this->assertStringNotContainsString('PROVEEDORES', (string) $response->getBody(), "No debería tener acceso a 'PROVEEDORES'");
        $this->assertStringNotContainsString('CONFIGURACIÓN', (string) $response->getBody(), "No debería tener acceso a 'CONFIGURACIÓN'");
    }
}
