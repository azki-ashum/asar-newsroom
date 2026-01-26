<?php

namespace Botble\Mitra\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Mitra\Http\Requests\MitraRequest;
use Botble\Mitra\Repositories\Interfaces\MitraInterface;
use Botble\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Botble\Mitra\Tables\MitraTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Mitra\Forms\MitraForm;
use Botble\Base\Forms\FormBuilder;

class MitraController extends BaseController
{
    protected MitraInterface $mitraRepository;

    public function __construct(MitraInterface $mitraRepository)
    {
        $this->mitraRepository = $mitraRepository;
    }

    public function index(MitraTable $table)
    {
        page_title()->setTitle(trans('plugins/mitra::mitra.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/mitra::mitra.create'));

        return $formBuilder->create(MitraForm::class)->renderForm();
    }

    public function store(MitraRequest $request, BaseHttpResponse $response)
    {
        $mitra = $this->mitraRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(MITRA_MODULE_SCREEN_NAME, $request, $mitra));

        return $response
            ->setPreviousUrl(route('mitra.index'))
            ->setNextUrl(route('mitra.edit', $mitra->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int $id, FormBuilder $formBuilder, Request $request)
    {
        $mitra = $this->mitraRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $mitra));

        page_title()->setTitle(trans('plugins/mitra::mitra.edit') . ' "' . $mitra->name . '"');

        return $formBuilder->create(MitraForm::class, ['model' => $mitra])->renderForm();
    }

    public function update(int $id, MitraRequest $request, BaseHttpResponse $response)
    {
        $mitra = $this->mitraRepository->findOrFail($id);

        $mitra->fill($request->input());

        $mitra = $this->mitraRepository->createOrUpdate($mitra);

        event(new UpdatedContentEvent(MITRA_MODULE_SCREEN_NAME, $request, $mitra));

        return $response
            ->setPreviousUrl(route('mitra.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Request $request, int $id, BaseHttpResponse $response)
    {
        try {
            $mitra = $this->mitraRepository->findOrFail($id);

            $this->mitraRepository->delete($mitra);

            event(new DeletedContentEvent(MITRA_MODULE_SCREEN_NAME, $request, $mitra));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $mitra = $this->mitraRepository->findOrFail($id);
            $this->mitraRepository->delete($mitra);
            event(new DeletedContentEvent(MITRA_MODULE_SCREEN_NAME, $request, $mitra));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
