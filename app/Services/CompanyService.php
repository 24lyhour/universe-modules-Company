<?php

namespace Modules\Company\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Modules\Company\Contracts\CompanyRepositoryInterface;
use Modules\Company\Models\Company;

class CompanyService
{
    public function __construct(
        protected CompanyRepositoryInterface $companyRepository
    ) {}

    /**
     * Get all companies.
     */
    public function getAllCompanies(): Collection
    {
        return $this->companyRepository->all();
    }

    /**
     * Get paginated companies.
     */
    public function getPaginatedCompanies(int $perPage = 15): LengthAwarePaginator
    {
        return $this->companyRepository->paginate($perPage);
    }

    /**
     * Get a company by ID.
     */
    public function getCompanyById(int $id): ?Company
    {
        return $this->companyRepository->find($id);
    }

    /**
     * Get a company by slug.
     */
    public function getCompanyBySlug(string $slug): ?Company
    {
        return $this->companyRepository->findBySlug($slug);
    }

    /**
     * Create a new company.
     */
    public function createCompany(array $data): Company
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);
        $data['user_id'] = auth()->id();

        return $this->companyRepository->create($data);
    }

    /**
     * Update a company.
     */
    public function updateCompany(int $id, array $data): bool
    {
        if (isset($data['name'])) {
            $company = $this->companyRepository->find($id);
            if ($company && $company->name !== $data['name']) {
                $data['slug'] = $this->generateUniqueSlug($data['name'], $id);
            }
        }

        return $this->companyRepository->update($id, $data);
    }

    /**
     * Delete a company.
     */
    public function deleteCompany(int $id): bool
    {
        return $this->companyRepository->delete($id);
    }

    /**
     * Get active companies.
     */
    public function getActiveCompanies(int $perPage = 15): LengthAwarePaginator
    {
        return $this->companyRepository->getActive($perPage);
    }

    /**
     * Get companies by industry.
     */
    public function getCompaniesByIndustry(string $industry, int $perPage = 15): LengthAwarePaginator
    {
        return $this->companyRepository->getByIndustry($industry, $perPage);
    }

    /**
     * Get companies by city.
     */
    public function getCompaniesByCity(string $city, int $perPage = 15): LengthAwarePaginator
    {
        return $this->companyRepository->getByCity($city, $perPage);
    }

    /**
     * Get companies by user.
     */
    public function getCompaniesByUser(int $userId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->companyRepository->getByUserId($userId, $perPage);
    }

    /**
     * Search companies.
     */
    public function searchCompanies(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->companyRepository->search($query, $perPage);
    }

    /**
     * Generate a unique slug for the company.
     */
    protected function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (true) {
            $existingCompany = $this->companyRepository->findBySlug($slug);

            if (! $existingCompany || ($excludeId && $existingCompany->id === $excludeId)) {
                break;
            }

            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
