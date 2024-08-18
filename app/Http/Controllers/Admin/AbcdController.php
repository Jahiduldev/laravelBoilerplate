<?php 
 
 
namespace App\Http\Controllers\Admin;

use App\Contracts\Services\AbcdServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Attributes\CategoryAttributes;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AbcdController extends Controller
{
    private AbcdServiceInterface $service;

    public function __construct(AbcdServiceInterface $service)
    {
        $this->service = $service;
    }

    public function show()
    {
        return view('admin.abcd.index')->with([
            'buttons' => [
                [
                    'label' => 'Add New',
                    'url' => route('abcd-add'),
                    'icon' => 'ti-plus'
                ],
            ],
            'headers' => [
                'Name',
                'Status',
                'Action'
            ],
        ]);
    }

    public function add()
    {
        return view('admin.abcd.add')->with([]);
    }

    public function create(CategoryRequest $request)
    {
        $request['status'] = $request->input('status') === 'on' ? Category::STATUS_ACTIVE : Category::STATUS_INACTIVE;

        $abcdAttributes = (new CategoryAttributes());
        $data = $abcdAttributes->updateDataRequest((new Category())->getFillable(), $request)->toArray();

        $response = $this->service->create($data);

        if ($response) {
            return redirect()->route('abcd-view')->with('success', 'Category added successfully.');
        }

        return redirect()->back()->with('error', 'Failed to upload file. Please try again.');
    }

    public function edit($id)
    {
        $response = $this->service->getById($id);

        return view('admin.abcd.edit')->with([
            'data' => $response,
        ]);
    }

    public function update(UpdateCategoryRequest $request)
    {
        $request['status'] = $request->input('status') === 'on' ? Category::STATUS_ACTIVE : Category::STATUS_INACTIVE;

        $abcdAttributes = (new CategoryAttributes());
        $data = $abcdAttributes->updateDataRequest((new Category())->getFillable(), $request)->toArray();

        $response = $this->service->update($request['id'], $data);

        if ($response) {
            return redirect()->route('abcd-view')->with('success', 'Occupation update successfully.');
        }

        return redirect()->back()->with('error', 'Failed to upload file. Please try again.');
    }

    public function list(Request $request)
    {
        return $this->service->dataTableList($request);
    }

    public function delete(Request $request)
    {
        $data = $this->service->delete($request->input('id'));

        if ($data) {
            return response()->json([
                'message' => 'Notice delete successfully',
                'status_code' => ResponseAlias::HTTP_OK,
                'data' => []
            ], ResponseAlias::HTTP_OK);
        }

        return response()->json([
            'message' => 'Notice delete successfully',
            'status_code' => ResponseAlias::HTTP_BAD_REQUEST,
            'data' => []
        ], ResponseAlias::HTTP_BAD_REQUEST);
    }

}
