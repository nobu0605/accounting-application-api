<?php
namespace Tests;

use Tests\TestCase;
use App\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

class PassportTestCase extends TestCase
{
    use DatabaseTransactions;
    
    protected $headersWithToken = [];
    protected $headersWithoutToken = [];
    protected $scopes = [];
    protected $user;
    
    public function setUp(): void
    {
        parent::setUp();

        // Personal Access ClientをDBに作成
        $clientRepository = new ClientRepository();
        $client = $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            url('/')
        );
        DB::table('oauth_personal_access_clients')->insert([
            'client_id' => $client->id,
            'created_at' => new \DateTime,
            'updated_at' => new \DateTime,
        ]);
        
        // ユーザーと、それに紐づく認証TokenをDBに作成
        $this->user = factory(User::class)->create();
        $token = $this->user->createToken('TestToken', $this->scopes)->accessToken;

        // リクエストのヘッダーを設定
        $this->headersWithToken['Accept'] = 'application/json';
        $this->headersWithToken['Authorization'] = 'Bearer '.$token;

        $this->headersWithoutToken['Accept'] = 'application/json';
    }
}
