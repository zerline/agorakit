@extends('app')

@section('content')
    <div class="d-flex gap-2 flex-wrap mb-2">
        @can('invite', $group)
            <a class="btn btn-primary" href="{{ action('InviteController@invite', $group) }}">
                {{ trans('membership.invite_by_email') }}
            </a>
        @endcan

        @can('manage-membership', $group)
            <div>
                <a class="btn btn-secondary" href="{{ action('GroupMassMembershipController@create', $group) }}">
                    {{ trans('membership.directly_add_users_button') }}
                </a>
            </div>
        @endcan
    </div>

    <div class="table">
        <table class="table data-table table-striped" data-order='[[ 3, "desc" ], [ 0, "asc" ]]' style="width: 100%">
            <thead class="thead-dark" style="width: 100%">
                <tr>
                    <th data-priority="1">{{ trans('messages.name') }}</th>
                    <th class="min-desktop" data-priority="3">{{ trans('messages.member_since') }}</th>
                    <th class="min-desktop" data-priority="4">{{ trans('messages.last_activity') }}</th>
                    <th class="min-tablet" data-priority="2">{{ trans('messages.status') }}</th>

                    @can('manage-membership', $group)
                        <th class="min-tablet-l" data-priority="2">{{ trans('messages.email') }}</th>
                        <th class="min-tablet-l" data-priority="2">{{ trans('messages.notifications_interval') }}</th>
                        <th data-priority="1" style="min-width: 2rem"></th>
                    @endcan

                </tr>
            </thead>

            <tbody>
                @foreach ($memberships as $membership)
                    <tr>
                        <td>
                            <a class="d-flex align-items-center" href="{{ route('users.show', $membership->user) }}">

                                <img alt="" class="avatar me-2" src="{{ route('users.cover', [$membership->user, 'small']) }}" />
                                <span>{{ $membership->user->name }}</span>
                            </a>
                        </td>

                        <td data-order="{{ $membership->created_at }}">
                            <a
                                href="{{ route('users.show', $membership->user) }}">{{ dateForHumans($membership->created_at) }}</a>
                        </td>

                        <td data-order="{{ $membership->user->updated_at }}">
                            <a
                                href="{{ route('users.show', $membership->user) }}">{{ dateForHumans($membership->user->updated_at) }}</a>
                        </td>

                        <td data-order="{{ $membership->membership }}">

                            @if ($membership->membership == \App\Membership::ADMIN)
                                <span class="tag text-bg-warning " title="@lang('This member is admin of the group and manages it')">
                                    {{ trans('membership.admin') }}
                                </span>
                            @endif
                            @if ($membership->membership == \App\Membership::MEMBER)
                                <span class="tag text-bg-primary" title="@lang('Regular member of the group')">
                                    {{ trans('membership.member') }}
                                </span>
                            @endif
                            @if ($membership->membership == \App\Membership::CANDIDATE)
                                <span class="tag text-bg-secondary" title="@lang('This user asked to be part of the group but has not yet been accepted')">
                                    {{ trans('membership.candidate') }}
                                </span>
                            @endif
                            @if ($membership->membership == \App\Membership::INVITED)
                                <span class="tag text-bg-success" title="@lang('This user has been invited to the group but did not accept yet')">
                                    {{ trans('membership.invited') }}
                                </span>
                            @endif

                            @if ($membership->membership == \App\Membership::DECLINED)
                                <span class="tag text-bg-dark " title="@lang('This member declined the invitagion the group')">
                                    {{ trans('membership.declined') }}
                                </span>
                            @endif

                            @if ($membership->membership == \App\Membership::UNREGISTERED)
                                <span class="tag text-bg-dark" title="@lang('This member left the group')">
                                    {{ trans('membership.unregistered') }}
                                </span>
                            @endif
                            @if ($membership->membership == \App\Membership::REMOVED)
                                <span class="tag text-bg-dark" title="@lang('This member has been removed from the group')">
                                    {{ trans('membership.removed') }}
                                </span>
                            @endif
                            @if ($membership->membership == \App\Membership::BLACKLISTED)
                                <span class="tag text-bg-dark" title="@lang('This member has been blacklisted')">
                                    {{ trans('membership.blacklisted') }}
                                </span>
                            @endif

                        </td>

                        @can('manage-membership', $group)
                            <td>
                                {{ $membership->user->email }}
                            </td>
                            <td data-order="{{ $membership->notification_interval }}">
                                <span class="rounded-full bg-green-600 text-green-100 px-2 py-1 text-xs capitalize">
                                    {{ minutesToInterval($membership->notification_interval) }}
                                </span>
                            </td>

                            <td>
                                <a class="rounded-full hover:bg-gray-400 w-10 h-10 d-flex align-items-center justify-center no-underline"
                                    href="{{ action('GroupMembershipAdminController@edit', [$group, $membership]) }}">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>

                            </td>
                        @endcan

                    </tr>
                @endforeach

            <tbody>

        </table>
    @endsection
