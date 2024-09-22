<?php

namespace App\Livewire;

use App\Livewire\Forms\ContactForm;
use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class ContactPage extends Component
{
    use SEOToolsTrait;

    public Page $page;

    public ContactForm $form;

    public array $breadcrumbs = [];

    public array $contacts = [];

    public function mount(): void
    {
        $this->page = Page::publicSelect()
            ->whereSlug('contacts')
            ->firstOrFail();

        $this->breadcrumbs[] = ['', $this->page->title];

        $this->contacts = $this->page->attrs['key_value'][0] ?? [];

        $this->seo()
            ->setTitle($this->page->meta_title)
            ->setDescription($this->page->meta_description);

        $this->fillForm();
    }

    private function fillForm(): void
    {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $this->form->fill([
            'name' => $user->full_name ?? null,
            'email' => $user->email ?? null,
            'phone' => $user->phone?->formatE164() ?? null,
        ]);
    }

    public function submit(): void
    {
        try {
            $this->form->store();
            session()->flash('status', 'Ваше сообщение успешно отправлено!');
        } catch (Throwable $th) {
            $this->addError('form', $th->getMessage());
        }
    }
}
