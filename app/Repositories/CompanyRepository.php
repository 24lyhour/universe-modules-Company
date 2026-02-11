<?php

namespace Modules\Company\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Company\Contracts\CompanyRepositoryInterface;
use Modules\Company\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function __construct(
        protected Company $model
    ) {}

    /**
     * Get all companies.
     */
    public function all(): Collection
    {
        return $this->model->with('user')->latest()->get();
    }

    /**
     * Get paginated companies.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('user')->latest()->paginate($perPage);
    }

    /**
     * Find a company by ID.
     */
    public function find(int $id): ?Company
    {
        return $this->model->with('user')->find($id);
    }

    /**
     * Find a company by slug.
     */
    public function findBySlug(string $slug): ?Company
    {
        return $this->model->with('user')->where('slug', $slug)->first();
    }

    /**
     * Create a new company.
     */
    public function create(array $data): Company
    {
        return $this->model->create($data);
    }

    /**
     * Update a company.
     */
    public function update(int $id, array $data): bool
    {
        $company = $this->find($id);

        if (! $company) {
            return false;
        }

        return $company->update($data);
    }

    /**
     * Delete a company.
     */
    public function delete(int $id): bool
    {
        $company = $this->find($id);

        if (! $company) {
            return false;
        }

        return $company->delete();
    }

    /**
     * Get active companies.
     */
    public function getActive(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('user')->active()->latest()->paginate($perPage);
    }

    /**
     * Get companies by industry.
     */
    public function getByIndustry(string $industry, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('user')->byIndustry($industry)->latest()->paginate($perPage);
    }

    /**
     * Get companies by city.
     */
    public function getByCity(string $city, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('user')->byCity($city)->latest()->paginate($perPage);
    }

    /**
     * Get companies by user ID.
     */
    public function getByUserId(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('user')->where('user_id', $userId)->latest()->paginate($perPage);
    }

    /**
     * Search companies by name.
     */
    public function search(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('user')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('industry', 'like', "%{$query}%")
            ->orWhere('city', 'like', "%{$query}%")
            ->latest()
            ->paginate($perPage);
    }
}
