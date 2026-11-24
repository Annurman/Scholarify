
<div class="mb-6 rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
    <form method="GET" action="{{ request()->url() }}"
          class="flex flex-wrap items-end gap-3">

        <div class="min-w-[220px] flex-1">
            <label for="kelompok" class="mb-2 block text-sm font-semibold text-gray-700">
                Kelompok Binaan
            </label>

            <select
                name="kelompok"
                id="kelompok"
                onchange="this.form.submit()"
                class="w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
                @forelse ($kelompok as $item)
                    <option
                        value="{{ $item->id }}"
                        @selected($selected && $selected->id == $item->id)
                    >
                        Kelompok #{{ $item->id }}
                    </option>
                @empty
                    <option value="">Belum ada kelompok binaan</option>
                @endforelse
            </select>
        </div>

        <button
            type="submit"
            class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700"
        >
            Tampilkan
        </button>
    </form>
</div>
