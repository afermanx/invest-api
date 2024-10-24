<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Active;
use App\Models\Transaction;
use App\Enums\Transaction\TypesEnum;
use App\Services\TransactionService;
use App\Http\Requests\Active\BuyActiveRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Resources\Transaction\TransactionResource;
use PHPUnit\Framework\Attributes\Test; // Importe o atributo Test

class BuyActiveControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $service;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um mock do TransactionService
        $this->service = $this->createMock(TransactionService::class);

        // Injeta o mock no container, substituindo a implementação original
        $this->app->instance(TransactionService::class, $this->service);

        $this->user = User::factory()->create();
    }

    #[Test]
    public function it_can_buy_an_active_with_user_auth()
    {
        // Cria um ativo e um usuário usando o factory
        $active = Active::factory()->create(['quantity' => 100]);
        $this->actingAs($this->user);

        // Dados de compra simulados
        $data = [
            'active_id' => $active->id,
            'quantity' => 10,
            'price' => 50,
            'date' => now(),
        ];

        // Cria uma transação simulada
        $transaction = new Transaction([
            'user_id' => $this->user->id,
            'active_id' => $active->id,
            'quantity' => 10,
            'price' => 50,
            'type' => TypesEnum::BUY,
            'total' => 500,
            'date' => now(),
        ]);

        // Define o retorno esperado para o método 'buy' do TransactionService
        $this->service->method('buy')
            ->willReturn($transaction);

        // Faz a requisição para o controlador
        $response = $this->postJson(route('active.buy'), $data);

        // Verifica se o status da resposta é 200 OK
        $response->assertOk();

        // Verifica se a estrutura do JSON retornado é a esperada

        $response->assertJsonStructure([
            'message',
            'data' => [
                'id',
                'quantity',
                'type',
                'price',
                'date',
                'total',
                'active',
                'user',
            ]
        ]);


    }
}
