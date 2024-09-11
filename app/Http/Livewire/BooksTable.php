<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;


class BooksTable extends DataTableComponent
{
    protected $model = Book::class; // Specify the model

    public ?string $search = ''; // Declare $search as ?string

    public array $filters = [
        'genre' => '',
        'publication_date_start' => null,
        'publication_date_end' => null,
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('title', 'asc');
        $this->setSearchEnabled();
        $this->setBulkActionsEnabled();
        $this->setPerPageAccepted([10, 25, 50, 100]);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Title", "title")
                ->searchable()
                ->sortable(),
            Column::make("Author",
 "author")
                ->searchable()
        ->sortable(),
            Column::make("Isbn", "isbn")
                ->searchable()
                ->sortable(),
            Column::make("Publication Date", "publication_date")
                ->sortable()
                ->filterable(DateFilter::class),
            Column::make("Genre", "genre")
                ->sortable()
                ->filterable(function () {
                    return Book::query()->select('genre')->distinct()->pluck('genre', 'genre')->toArray();
                }),
            Column::make("Number of Copies", "number_of_copies")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),






            Column::make('Actions')
                ->format(function($value, $column, $row) {
                    return view('admin.user.actions', ['book' => $row]);
                })->html(),



        ];
    }

    public function query(): Builder
    {
        return Book::query()
            ->when($this->getSearch(), fn ($query, $term) => $query->search($term))
            ->when($this->getFilter('genre'), fn ($query, $genre) => $query->where('genre', $genre))
            ->when($this->getFilter('publication_date_start'), fn ($query, $date) => $query->where('publication_date', '>=', $date))
            ->when($this->getFilter('publication_date_end'), fn ($query, $date) => $query->where('publication_date', '<=', $date));
    }

    // Add bulk actions if needed
    public function bulkActions(): array
    {
        return [
            'deleteSelected' => 'Delete Selected',
        ];
    }

    public function deleteSelected()
    {
        // Handle deleting selected books (implement logic here)
    }

    public function model(): string
    {
        return Book::class;
    }

    public function builder(): Builder
    {
        return Book::query(); // Or customize your query here
    }
}
