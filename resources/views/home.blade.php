@extends('layouts.app')

@section('content')
    @include('navbar')

    @include('carousel')




    <div>
        <div class="container mx-auto py-3">
            <form method="POST" action="{{ route('home') }}">
                @csrf

                <input class="border-gray-300 text-sm w-96" type="text" name="search" placeholder="<Type your search terms>"
                    value="{{ $search }}">
                <button type="submit" class="etalk_button">Search
                </button>

            </form>
        </div>

        @foreach ($talks as $talk)
            @php
                $firstSound = $talk->sounds->first();
            @endphp
            <article class="container mx-auto flex justify-start mb-10 bg-white p-6">
                <div class="w-1/4">
                    <a href="#" target="_blank" rel="noopener noreferrer">
                        <img class="w-full" src="{{ $firstSound ? $firstSound->getFirstMediaUrl() : '' }}" alt="image">
                    </a>
                </div>

                <div class="pt-1 px-6 w-3/4">
                    <h2 class="text-3xl font-weight-bolder mb-2">
                        <a href="{{ route('talk.show', $talk) }}" target="_blank" rel="noopener noreferrer">
                            @if ($search)
                                {!! preg_replace('/(' . $search . ')/i', "<span class=\"searched\">$1</span>", $talk->title) !!}
                            @else
                                {{ $talk->title }}
                            @endif
                        </a>
                    </h2>



                    <div class="text-gray-400">
                        @if ($search)
                            {!! preg_replace('/(' . $search . ')/i', "<span class=\"searched\">$1</span>", $talk->author) !!}
                        @else
                            {{ $talk->author }}
                        @endif |
                        <a href="#">eTalk</a> |
                        {{ $talk->duration }} |
                        {{ $talk->date->format('F d, Y') }}
                        <br>
                        Metadata: <a href="{{ $talk->external_id }}" target="_blank">{{ $talk->external_id }}</a>

                        @if ($search)
                            <div>
                                <table class="table-auto">
                                    <tbody>
                                        @foreach ($talk->metadatasTable() as $name => $value)
                                            <tr class="align-top">
                                                <td>{{ $name }}</td>
                                                <td>
                                                    @if (is_array($value))
                                                        <ul>
                                                            @foreach ($value as $name2 => $value2)
                                                                <li>
                                                                    @if ($search)
                                                                        {!! preg_replace('/(' . $search . ')/i', "<span class=\"searched\">$1</span>", $value2) !!}
                                                                    @else
                                                                        {{ $value2 }}
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        @if ($search)
                                                            {!! preg_replace('/(' . $search . ')/i', "<span class=\"searched\">$1</span>", $value) !!}
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>


                    <div class="float-right">
                        <a class="etalk_button" href="#" target="_blank" rel="noopener noreferrer">Read eTalk</a>
                    </div>

                </div>
            </article>
        @endforeach
    </div>
@endsection
