<?php

namespace Botble\Gallery\Forms;

use Botble\Base\Forms\FieldOptions\EditorFieldOption;
use Botble\Base\Forms\FieldOptions\IsFeaturedFieldOption;
use Botble\Base\Forms\FieldOptions\MediaImageFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\SortOrderFieldOption;
use Botble\Base\Forms\FieldOptions\StatusFieldOption;
use Botble\Base\Forms\Fields\EditorField;
use Botble\Base\Forms\Fields\MediaImageField;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\Fields\UrlField;
use Botble\Base\Forms\FormAbstract;
use Botble\Gallery\Http\Requests\GalleryRequest;
use Botble\Gallery\Models\Gallery;

class GalleryForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Gallery::class)
            ->setValidatorClass(GalleryRequest::class)
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('description', EditorField::class, EditorFieldOption::make()->required())
            ->add('order', NumberField::class, SortOrderFieldOption::make())
            ->add(
                'is_featured',
                OnOffField::class,
                IsFeaturedFieldOption::make()
            )
            ->add('status', SelectField::class, StatusFieldOption::make())
            ->add('image', MediaImageField::class, MediaImageFieldOption::make())
            ->add('url_1', TextField::class, [
                'label' => 'URL',
                'attr' => [
                    'placeholder' => 'https://example.com',
                ],
                'help' => 'URL untuk redirect ketika gallery diklik di home banner',
            ])
            // ->add('caption_url_1', TextField::class, [
            //     'label' => 'Caption URL 1',
            //     'attr' => [
            //         'placeholder' => 'Caption untuk URL',
            //     ],
            // ])
            ->setBreakFieldPoint('status');
    }
}
