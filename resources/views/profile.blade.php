<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $name }} — Student Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-mystic font-sans text-lucky-point antialiased">

    <div class="mx-auto flex min-h-screen max-w-3xl items-center px-6 py-12">
        <div class="w-full overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-lucky-point/10">

            {{-- Header --}}
            <header class="bg-lucky-point px-8 py-10 text-center sm:text-left">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cornflower">
                    Student Profile
                </p>
                <h1 class="mt-2 text-3xl font-bold text-white sm:text-4xl">
                    {{ $name }}
                </h1>
                <p class="mt-2 text-cornflower">
                    {{ $program }} &middot; {{ $year_level }}
                </p>
            </header>

            <div class="space-y-8 px-8 py-8">

                {{-- Details --}}
                <section class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl bg-mystic p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Program</p>
                        <p class="mt-1 text-lg font-semibold">{{ $program }}</p>
                    </div>
                    <div class="rounded-xl bg-mystic p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Year Level</p>
                        <p class="mt-1 text-lg font-semibold">{{ $year_level }}</p>
                    </div>
                </section>

                {{-- Skills --}}
                <section>
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-ship-cove">Top Skills</h2>
                    <ul class="mt-3 flex flex-wrap gap-2">
                        @foreach ($skills as $skill)
                            <li class="rounded-full bg-cornflower/30 px-4 py-2 text-sm font-medium text-lucky-point">
                                {{ $skill }}
                            </li>
                        @endforeach
                    </ul>
                </section>

                {{-- Career goal --}}
                <section class="rounded-xl border-l-4 border-ship-cove bg-mystic p-5">
                    <h2 class="text-sm font-semibold uppercase tracking-wider text-ship-cove">Career Goal</h2>
                    <p class="mt-2 leading-relaxed">{{ $career_goal }}</p>
                </section>

            </div>

            <footer class="border-t border-mystic px-8 py-4 text-center text-xs text-ship-cove">
                Route &rarr; Controller &rarr; View &nbsp;·&nbsp;
                <span class="font-medium">profile.show</span> &rarr;
                <span class="font-medium">ProfileController@show</span> &rarr;
                <span class="font-medium">profile.blade.php</span>
            </footer>

        </div>
    </div>

</body>
</html>
