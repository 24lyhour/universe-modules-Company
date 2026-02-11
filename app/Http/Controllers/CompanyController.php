<?php

namespace Modules\Company\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Company\Http\Requests\StoreCompanyRequest;
use Modules\Company\Http\Requests\UpdateCompanyRequest;
use Modules\Company\Services\CompanyService;

class CompanyController extends Controller
{
    public function __construct(
        protected CompanyService $companyService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $companies = $this->companyService->getPaginatedCompanies();

        return Inertia::render('company::Index', [
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('company::Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $this->companyService->createCompany($request->validated());

        return redirect()
            ->route('company.index')
            ->with('success', 'Company created successfully.');
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id): Response
    {
        $company = $this->companyService->getCompanyById($id);

        if (! $company) {
            abort(404);
        }

        return Inertia::render('company::Show', [
            'company' => $company,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): Response
    {
        $company = $this->companyService->getCompanyById($id);

        if (! $company) {
            abort(404);
        }

        return Inertia::render('company::Edit', [
            'company' => $company,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, int $id): RedirectResponse
    {
        $updated = $this->companyService->updateCompany($id, $request->validated());

        if (! $updated) {
            abort(404);
        }

        return redirect()
            ->route('company.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): RedirectResponse
    {
        $deleted = $this->companyService->deleteCompany($id);

        if (! $deleted) {
            abort(404);
        }

        return redirect()
            ->route('company.index')
            ->with('success', 'Company deleted successfully.');
    }
}
