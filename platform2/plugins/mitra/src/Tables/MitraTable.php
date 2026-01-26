<?php

namespace Botble\Mitra\Tables;

use Illuminate\Support\Facades\Auth;
use BaseHelper;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Mitra\Repositories\Interfaces\MitraInterface;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;
use Html;

class MitraTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, MitraInterface $mitraRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $mitraRepository;

        if (!Auth::user()->hasAnyPermission(['mitra.edit', 'mitra.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('mitra.edit')) {
                    return BaseHelper::clean($item->name);
                }
                return Html::link(route('mitra.edit', $item->id), BaseHelper::clean($item->name));
            })
            ->editColumn('slug', function ($item) {
                if (!Auth::user()->hasPermission('mitra.edit')) {
                    return BaseHelper::clean($item->slug);
                }
                return Html::link(route('mitra.edit', $item->id), BaseHelper::clean($item->slug));
            })
            ->editColumn('id_cabang', function ($item) {
                if (!Auth::user()->hasPermission('mitra.edit')) {
                    return BaseHelper::clean($item->id_cabang);
                }
                return Html::link(route('mitra.edit', $item->id), BaseHelper::clean($item->id_cabang));
            })
            ->editColumn('type', function ($item) {
                if (!Auth::user()->hasPermission('mitra.edit')) {
                    return BaseHelper::clean($item->type);
                }
                return Html::link(route('mitra.edit', $item->id), BaseHelper::clean($item->type));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('mitra.edit', 'mitra.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()
            ->select([
               'id',
               'name',
               'slug',
               'id_cabang',
               'type',
               'created_at',
               'status',
           ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'title' => 'Nama Mitra/Ksatria',
                'class' => 'text-start',
            ],
            'slug' => [
                'title' => 'Slug',
                'class' => 'text-start',
            ],
            'id_cabang' => [
                'title' => 'Cabang',
                'class' => 'text-start',
            ],
            'type' => [
                'title' => 'Type',
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('mitra.create'), 'mitra.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('mitra.deletes'), 'mitra.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title'    => 'Nama Mitra/Ksatria',
                'type'     => 'text',
                'validate' => 'required|max:255',
            ],
            'slug' => [
                'title'    => 'Slug',
                'type'     => 'text',
                'validate' => 'required|max:55',
            ],
            'id_cabang' => [
                'title'    => 'Kode Cabang',
                'type'     => 'number',
                'validate' => 'required|min:1',
            ],
            'type' => [
                'title'    => 'Type 1:Mitra, 2:Ksatria',
                'type'     => 'number',
                'validate' => 'required|min:1',
            ],            
            'status' => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }

    public function getFilters(): array
    {
        return $this->getBulkChanges();
    }
}
