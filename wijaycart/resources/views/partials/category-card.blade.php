<a
    href="{{ route('products.index', ['category' => $category->slug]) }}"
    class="card-hover group text-center"
>
    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-3xl bg-white shadow-sm ring-1 ring-border/40 transition-all duration-300 group-hover:-translate-y-1 group-hover:shadow-md dark:bg-dark-card dark:ring-dark-border">
        <i data-lucide="{{ $category->icon }}" class="h-9 w-9 text-accent dark:text-primary" aria-hidden="true"></i>
    </div>
    <h3 class="font-semibold">{{ $category->name }}</h3>
    @if(isset($category->active_products_count))
        <p class="mt-1 text-xs text-text/50 dark:text-dark-muted">{{ $category->active_products_count }} produk</p>
    @elseif(isset($category->products_count))
        <p class="mt-1 text-xs text-text/50 dark:text-dark-muted">{{ $category->products_count }} produk</p>
    @endif
</a>
