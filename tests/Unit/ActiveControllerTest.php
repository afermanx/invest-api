<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Active;
use App\Services\ActiveService; // Certifique-se de importar o serviço
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Pagination\LengthAwarePaginator;
use PHPUnit\Framework\Attributes\Test; // Importe o atributo Test

class ActiveControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $service;

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um mock do ActiveService
        $this->service = $this->createMock(ActiveService::class);

        // Injeta o mock no container, substituindo a implementação original
        $this->app->instance(ActiveService::class, $this->service);

        $this->user = User::factory()->create();
    }

    #[Test]
    public function it_can_list_all_actives_with_user_auth()
    {
        // Cria uma coleção de ativos usando o factory
        $actives = Active::factory()->count(5)->create(['user_id' => $this->user->id]);

        // Cria uma instância de LengthAwarePaginator simulando a paginação
        $paginator = new LengthAwarePaginator(
            $actives, // A coleção de dados
            5,        // Total de itens (para paginação)
            10        // Itens por página
        );

        // Define o retorno esperado para o método 'list' do ActiveService
        $this->service->method('list')
            ->willReturn($paginator);

        // Faz a requisição para a rota de listagem de ativos
        $response = $this->actingAs($this->user) // Garante que o usuário está autenticado
                         ->getJson(route('actives.index'));

        // Verifica se o status da resposta é 200 OK
        $response->assertOk();

        // Verifica se a estrutura do JSON retornado é a esperada
        $response->assertJsonStructure([
            'data' => [ // Valida que existe um array de 'data'
                '*' => [ // Cada item no array 'data' deve ter as seguintes chaves:
                    'id',
                    'name',
                    'ticker', // O nome correto é 'ticker'
                    'purchase_date',
                    'quantity',
                    'price',
                    'type',
                    'user' => [ // Verifica a estrutura do shale
                        'id',
                        'name',
                        'email',
                    ]
                ]
            ],
            'from',
            'last_page',
            'per_page',
            'to',
            'total',
            'current_page',
        ]); // Verifica se o número de itens na resposta JSON é igual ao esperado
        $this->assertCount(5, $response->json('data'));
    }
    #[Test]
    public function it_can_show_an_active_with_user_auth()
    {
        // Cria um ativo usando o factory
        $active = Active::factory()->create(['user_id' => $this->user->id]);

        // Define o retorno esperado para o método 'show' do ActiveService
        $this->service->method('find')
            ->willReturn($active);

        // Faz a requisição para a rota de visualização de ativos
        $response = $this->actingAs($this->user) // Garante que o usuário está autenticado
                         ->getJson(route('actives.show', $active->id));

        // Verifica se o status da resposta é 200 OK
        $response->assertOk();

        // Verifica se a estrutura do JSON retornado é a esperada
        $response->assertJsonStructure([
            'id',
            'name',
            'ticker', // O nome correto é 'ticker'
            'purchase_date',
            'quantity',
            'price',
            'type',
            'user' => [ // Verifica a estrutura do shale
                'id',
                'name',
                'email',
            ]
        ]);
    }

    #[Test]
    public function it_can_create_an_active_with_user_auth()
    {
        // Cria um ativo usando o factory
        $active = Active::factory()->make(['user_id' => $this->user->id]);

        // Define o retorno esperado para o método 'create' do ActiveService
        $this->service->method('create')
            ->willReturn($active);

        // Faz a requisição para a rota de criação de ativos
        $response = $this->actingAs($this->user) // Garante que o usuário está autenticado
                         ->postJson(route('actives.store'), $active->toArray());

        // Verifica se o status da resposta é 201 Created
        $response->assertOk();

        // Verifica se a estrutura do JSON retornado é a esperada
        $response->assertJsonStructure([
            'id',
            'name',
            'ticker', // O nome correto é 'ticker'
            'purchase_date',
            'quantity',
            'price',
            'type',
            'user' => [ // Verifica a estrutura do shale
                'id',
                'name',
                'email',
            ]
        ]);
    }

    #[Test]
    public function it_can_update_an_active_with_user_auth()
    {
        // Cria um ativo usando o factory
        $active = Active::factory()->create(['user_id' => $this->user->id]);

        // Define o retorno esperado para o método 'update' do ActiveService
        $this->service->method('update')
            ->willReturn($active);

        // Faz a requisição para a rota de atualizacao de ativos
        $response = $this->actingAs($this->user) // Garante que o shale estava autenticado
                         ->patchJson(route('actives.update', $active->id), $active->toArray());

        // Verifica se o status da resposta é 200 OK
        $response->assertOk();
    }

    #[Test]
    public function it_can_delete_an_active_with_user_auth()
    {
        // Cria um ativo usando o factory
        $active = Active::factory()->create(['user_id' => $this->user->id]);

        // Define o retorno esperado para o método 'delete' do ActiveService
        $this->service->method('delete')
            ->willReturn($active);

        // Faz a requisição para a rota de exclusão de ativos
        $response = $this->actingAs($this->user) // Garante que o usuário está autenticado
                         ->deleteJson(route('actives.destroy', $active->id));

        // Verifica se o status da resposta é 204 No Content
        $response->assertNoContent();
    }
}
