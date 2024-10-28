
@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="small table-primary text-secondary">
            <tr>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED_AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($all_posts as $post)
                <tr>
                    <td>
                        @if ($post->image)
                        <a href="{{ route('post.show',$post->id) }}">
                            <img src="{{ $post->image }}" alt="{{ $post->name }}" class="d-block mx-auto image-md">
                        </a>
                        @endif
                    </td>
                    <td>
                            @forelse ($post->categoryPost as $category_post)
                                <span class="badge bg-secondary bg-opacity-50">
                                    {{ $category_post->category->name }}
                                </span>
                            @empty
                                <div class="badge bg-dark text-wrap">Uncategorized</div>
                            @endforelse
                    </td>
                    <td>
                        <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark fw-bold">{{$post->user->name}}</a>
                    </td>
                    <td>{{ $post->created_at }}</td>
                    <td>
                        @if ($post->trashed()) {{-- trashed = softdeleted / destroyed --}}
                            <i class="fa-regular fa-circle text-secondary"></i>&nbsp; Hidden
                        @else
                            <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible
                        @endif
                        
                    </td>
                    <td>
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>    
                                </button>    

                                <div class="dropdown-menu">
                                    @if ($post->trashed())
                                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#show-post-{{ $post->id }}">
                                            <i class="fa-solid fa-eye-slash"></i> Show Post
                                        </button>
                                    @else
                                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
                                        <i class="fa-solid fa-eye-slash"></i> Hide Post
                                        </button>
                                    @endif
                                </div>
                            </div>                            
                            {{-- Include the modal here --}}
                            @include('admin.posts.modal.status')           
                    </td>
                </tr>
            @empty
            <tr>
                <td class="lead text-muted text-center">No Posts found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $all_posts->links() }}
    </div>
@endsection
