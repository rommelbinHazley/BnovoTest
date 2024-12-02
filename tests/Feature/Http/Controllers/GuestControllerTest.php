<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Guest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    use DatabaseMigrations;

    private const ROUTE_RESOURCE = '/api/guest';

    #[DataProvider('getStoreDataSuccess')]
    public function test_store(array $data, array $successData): void
    {
        $response = $this->postJson(self::ROUTE_RESOURCE, $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas(Guest::class, $successData);
    }

    #[DataProvider('getStoreDataFailed')]
    public function test_store_failed(array $data, int $expectedErrorsCount): void
    {
        $response = $this->postJson(self::ROUTE_RESOURCE, $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertCount($expectedErrorsCount, $responseData['errors']);
    }

    #[DataProvider('getUpdateDataSuccess')]
    public function test_update(array $data, array $successData): void
    {
        $guest = Guest::factory()->create();
        $response = $this->putJson(self::ROUTE_RESOURCE.'/'.$guest->getKey(), $data);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas(Guest::class, $successData);
    }

    #[DataProvider('getUpdateDataFailed')]
    public function test_update_failed(array $data, int $expectedErrorsCount): void
    {
        $guest = Guest::factory()->create();
        $response = $this->putJson(self::ROUTE_RESOURCE.'/'.$guest->getKey(), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $responseData = $response->json();

        $this->assertCount($expectedErrorsCount, $responseData['errors']);
    }

    public function test_delete(): void
    {
        $guest = Guest::factory()->create();
        $this->deleteJson(self::ROUTE_RESOURCE.'/'.$guest->getKey());

        $this->assertDatabaseCount('guests', 0);
    }

    public function test_show(): void
    {
        $guest = Guest::factory()->create();
        $response = $this->getJson(self::ROUTE_RESOURCE.'/'.$guest->getKey());

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                'id' => $guest->getAttribute('id'),
                'name' => $guest->getAttribute('name'),
                'surname' => $guest->getAttribute('surname'),
                'fullName' => $guest->getAttribute('name').' '.$guest->getAttribute('surname'),
                'email' => $guest->getAttribute('email'),
                'country' => $guest->getAttribute('country'),
                'phone' => $guest->getAttribute('phone'),
            ],
            'success' => true,
        ]);
    }

    public function test_index(): void
    {
        $guests = Guest::factory()->createMany(3);
        $response = $this->getJson(self::ROUTE_RESOURCE);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJson([
            'data' => [
                [
                    'id' => $guests[0]->getAttribute('id'),
                    'name' => $guests[0]->getAttribute('name'),
                    'surname' => $guests[0]->getAttribute('surname'),
                    'fullName' => $guests[0]->getAttribute('name').' '.$guests[0]->getAttribute('surname'),
                    'email' => $guests[0]->getAttribute('email'),
                    'country' => $guests[0]->getAttribute('country'),
                    'phone' => $guests[0]->getAttribute('phone'),
                ],
                [
                    'id' => $guests[1]->getAttribute('id'),
                    'name' => $guests[1]->getAttribute('name'),
                    'surname' => $guests[1]->getAttribute('surname'),
                    'fullName' => $guests[1]->getAttribute('name').' '.$guests[1]->getAttribute('surname'),
                    'email' => $guests[1]->getAttribute('email'),
                    'country' => $guests[1]->getAttribute('country'),
                    'phone' => $guests[1]->getAttribute('phone'),
                ],
                [
                    'id' => $guests[2]->getAttribute('id'),
                    'name' => $guests[2]->getAttribute('name'),
                    'surname' => $guests[2]->getAttribute('surname'),
                    'fullName' => $guests[2]->getAttribute('name').' '.$guests[2]->getAttribute('surname'),
                    'email' => $guests[2]->getAttribute('email'),
                    'country' => $guests[2]->getAttribute('country'),
                    'phone' => $guests[2]->getAttribute('phone'),
                ],
            ],
            'success' => true,
        ]);
    }

    /**
     * @return array[]
     */
    public static function getStoreDataSuccess(): array
    {
        return [
            'successWithCountry' => [
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '+79617112471',
                    'country' => 'RU',
                ],
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '79617112471',
                    'country' => 'RU',
                ],
            ],
            'successWithoutCountry' => [
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '+86 138 0013 8000',
                ],
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '8613800138000',
                    'country' => 'CN',
                ],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public static function getUpdateDataSuccess(): array
    {
        return [
            'successWithCountry' => [
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '+79617112471',
                    'country' => 'RU',
                ],
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '79617112471',
                    'country' => 'RU',
                ],
            ],
            'successWithoutCountry' => [
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '+86 138 0013 8000',
                ],
                [
                    'name' => 'Danil',
                    'surname' => 'Lebedev',
                    'email' => 'hazleyishero@gmail.ru',
                    'phone' => '8613800138000',
                    'country' => 'CN',
                ],
            ],
        ];
    }

    /**
     * @return array[]
     */
    public static function getStoreDataFailed(): array
    {
        return [
            'required' => [
                [], 4,
            ],
            'max' => [
                [
                    'name' => 'TestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLength',
                    'surname' => 'TestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLength',
                    'email' => 'hazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyishero@gmail.ru',
                    'phone' => '+21412421412421421424214124124',
                ],
                4,
            ],
            'types' => [
                [
                    'name' => 1,
                    'surname' => 2,
                    'email' => 3,
                    'phone' => 4,
                ],
                4,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public static function getUpdateDataFailed(): array
    {
        return [
            'required' => [
                [],
                4,
            ],
            'max' => [
                [
                    'name' => 'TestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLength',
                    'surname' => 'TestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLengthTestLength',
                    'email' => 'hazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyisherohazleyishero@gmail.ru',
                    'phone' => '+21412421412421421424214124124',
                ],
                4,
            ],
            'types' => [
                [
                    'name' => 1,
                    'surname' => 2,
                    'email' => 3,
                    'phone' => 4,
                ],
                4,
            ],
        ];
    }
}
