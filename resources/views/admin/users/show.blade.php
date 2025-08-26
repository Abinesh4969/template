@extends('layouts.app')

@section('content')
<!-- Breadcrumb Start -->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Users</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="{{ route('dashboard') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">Users</li>
    </ul>
</div>
<!-- Breadcrumb End -->
<div class="mt-1 -ml-3 -mr-3 rounded-none card">
<!-- Profile Card Start -->
<div class="card-body !px-2.5">
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-12 2xl:grid-cols-12">

        <!-- Profile Image -->
        <div class="lg:col-span-2 2xl:col-span-1">
            <div class="relative inline-block rounded-full shadow-md size-20 bg-slate-100 profile-user xl:size-28">
                @php
                    $media = $user->getFirstMedia('profile_image');
                @endphp

                @if($media)
                    <img src="{{ asset('storage/app/public/' . $media->id . '/' . $media->file_name) }}" 
                        alt="User Avatar" 
                        class="object-cover border-0 rounded-full img-thumbnail user-profile-image">
                @else
                    <img src="{{ asset('app-assets/images/users/user-dummy-img.jpg') }}" 
                        alt="Default Avatar" 
                        class="object-cover border-0 rounded-full img-thumbnail user-profile-image">
                @endif
            </div>
        </div>


        <!-- Profile Info -->
        <div class="lg:col-span-10 2xl:col-span-9">
            <h5 class="mb-1">
                {{ $user->name }}
                <!-- <i data-lucide="badge-check" class="inline-block size-4 text-sky-500 fill-sky-100 dark:fill-custom-500/20"></i> -->
            </h5>

            <div class="flex gap-3 mb-4">
                <p class="text-slate-500 dark:text-zink-200">
                    <i data-lucide="user-circle" class="inline-block size-4 ltr:mr-1 rtl:ml-1"></i>
                    {{ $user->role }}
                </p>
                <!-- <p class="text-slate-500 dark:text-zink-200">
                    <i data-lucide="map-pin" class="inline-block size-4 ltr:mr-1 rtl:ml-1"></i>
                    {{ $user->address }}
                </p> -->
            </div>

            <!-- Contact -->
            <div class="flex flex-col gap-1 mb-4">
                <p class="text-slate-600 dark:text-zink-200"><strong>Email:</strong> {{ $user->email }}</p>
                <p class="text-slate-600 dark:text-zink-200"><strong>Phone:</strong> {{ $user->phone }}</p>
                <p class="text-slate-600 dark:text-zink-200"><strong>DOB:</strong> {{ $user->dob }}</p>
                <p class="text-slate-600 dark:text-zink-200"><strong>Gender:</strong> {{ ucfirst($user->gender) }}</p>
                <p class="text-slate-600 dark:text-zink-200"><strong>Nationality:</strong> {{ $user->nationality }}</p>
                <p class="text-slate-600 dark:text-zink-200"><strong>Country of Residence:</strong> {{ $user->country_of_residence }}</p>
                <p class="text-slate-600 dark:text-zink-200"><strong>Unique Code:</strong> {{ $user->unique_code }}</p>
            </div>
        </div>
    </div><!-- end grid -->
</div>
</div>
<!-- Profile Card End -->
    <!--  -->
<div class="2xl:col-span-3">
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">KYC Information</h6>
            <div class="overflow-x-auto">
                <table class="w-full ltr:text-left rtl:text-right">
                    <tbody>
                        <tr>
                            <th class="py-2 font-semibold ps-0" scope="row">Government ID Type</th>
                            <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                {{ ucfirst($kyc?->government_id_type ?? '-') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2 font-semibold ps-0" scope="row">Government ID Number</th>
                            <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                {{ $kyc?->government_id_number ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2 font-semibold ps-0" scope="row">Tax ID</th>
                            <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                {{ $kyc?->tax_id ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2 font-semibold ps-0" scope="row">Address</th>
                            <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                {{ $kyc?->address_line ?? '-' }},
                                {{ $kyc?->city?->name ?? '-' }},
                                {{ $kyc?->state?->name ?? '-' }},
                                {{ $kyc?->district?->name ?? '-' }},
                                {{ $kyc?->postal_code ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th class="py-2 font-semibold ps-0" scope="row">Verified</th>
                            <td class="py-2 text-right text-slate-500 dark:text-zink-200">
                                {!! $kyc?->is_verified
                                    ? '<span class="text-green-500">Verified</span>'
                                    : '<span class="text-red-500">Not Verified</span>' !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!--end card-->

    <div class="card mt-4">
        <div class="card-body">
            <h6 class="mb-4 text-15">KYC Documents</h6>
            <div class="divide-y divide-slate-200 dark:divide-zink-500">
    @foreach([
        'government_id_file' => 'Government ID File',
        'proof_of_address_file' => 'Proof of Address',
        'live_selfie_file' => 'Live Selfie',
        'partnership_agreement_file' => 'Partnership Agreement',
        'contracts_file' => 'Contracts',
        'nda_file' => 'NDA'
    ] as $collection => $label)
        @php
            $media = $kyc?->getFirstMedia($collection);
        @endphp

        <div class="flex items-center justify-between py-3">
            <span class="font-semibold text-slate-700 dark:text-zink-200">{{ $label }}</span>

            @if($media)
                @if(in_array($media->mime_type, ['image/jpeg', 'image/png', 'image/jpg']))
                    <img src="{{ asset('storage/app/public/' . $media->id . '/' . $media->file_name) }}"
                         alt="{{ $label }}"
                         class="object-cover border-0 rounded img-thumbnail size-16">
                @else
                    <a href="{{ asset('storage/app/public/' . $media->id . '/' . $media->file_name) }}"
                       target="_blank"
                       class="text-custom-500 underline">View File</a>
                @endif
            @else
                <span class="text-slate-400">No File Uploaded</span>
            @endif
        </div>
    @endforeach
</div>

        </div>
    </div><!--end card-->
</div>

        <!--  -->
@endsection
