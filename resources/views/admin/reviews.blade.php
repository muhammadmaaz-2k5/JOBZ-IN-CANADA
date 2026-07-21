<x-app-layout>
    <x-slot name="header">
        <div>
            <h2>
                {{ __('Company Review Moderation') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}">
                &larr; Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div>
        <div>
            
            @if(session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Reviews List Table -->
            <div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Company</th>
                                <th>User</th>
                                <th>Rating</th>
                                <th>Title / Review content</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reviews as $rev)
                                <tr>
                                    <td>{{ $rev->company->company_name }}</td>
                                    <td>{{ $rev->user->first_name }} {{ $rev->user->last_name }}</td>
                                    <td>
                                        @for($i=1;$i<=5;$i++)
                                            {{ $i <= $rev->rating ? '★' : '☆' }}
                                        @endfor
                                    </td>
                                    <td>
                                        <div>"{{ $rev->title }}"</div>
                                        <p>"{{ $rev->review }}"</p>
                                    </td>
                                    <td>
                                        <!-- Actions (Delete) -->
                                        <form method="POST" action="{{ route('admin.reviews.status', $rev->id) }}">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Remove review permanent?');">
                                                Delete Review
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No company reviews found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $reviews->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
