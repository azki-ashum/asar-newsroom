<?php

namespace Botble\Mitra\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Mitra\Http\Requests\MitraRequest;
use Botble\Mitra\Models\Mitra;

class MitraForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Mitra)
            ->setValidatorClass(MitraRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label' => 'Nama Mitra atau Ksatria',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => 'Input Nama Lengkap Mitra atau Ksatria',
                    'data-counter' => 255,
                ],
            ])
            ->add('slug', 'text', [
                'label' => 'Slug',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => 'Input Slug (Slug Tidak Boleh Spasi, Karakter Khusus) dan HARUS Huruf Kecil, Contoh ishak-komarudin',
                    'data-counter' => 55,
                ],
            ])
            ->add('id_cabang', 'number', [
                'label' => 'Cabang',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => 'Masukan Kode Cabang',
                    'default_value' => 1,
                ],
            ])
            ->add('type', 'number', [
                'label' => 'Type (1. Mitra, 2. Ksatria)',
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => 'Masukan Type',
                    'default_value' => 2,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'form-control select-full',
                ],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
