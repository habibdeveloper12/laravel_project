@extends('frontend.layouts.master')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

<style>
    body{margin-top:20px;
        background:#eee;
    }
    .fs35 {
        font-size: 35px !important;
    }

    .mw50 {
        max-width: 50px !important;
    }
    .mn {
        margin: 0 !important;
    }
    .mw140 {
        max-width: 140px !important;
    }
    .mb20 {
        margin-bottom: 20px !important;
    }
    .mr25 {
        margin-right: 25px !important;
    }

    .mw40 {
        max-width: 40px !important;
    }

    .p30 {
        padding: 30px !important;
    }
    #content{
        margin-top: 30px;
        border-radius: 5px;
    }

    @media only screen and (max-width: 991px) {
        #content{
            margin-top: 40px;
        }
        .page-heading {
            margin-top: -25px !important;

        }
    }

    .page-heading {
        position: relative;
        padding: 30px 40px;
        border-radius: 5px;
        margin: 0px -20px 25px;
        border-bottom: 1px solid #d9d9d9;
        background-color: var(--col);
        margin-top: 10px;
    }
    .page-tabs {
        margin: -25px -20px 30px;
        padding: 15px 25px 0;
        border-bottom: 1px solid #ddd;
        background: #e9e9e9;
    }
    .page-tabs .nav-tabs {
        border-bottom: 0;
    }
    .page-tabs .nav-tabs > li > a {
        color: #AAA;
        padding: 10px 20px;
    }
    .page-tabs .nav-tabs > li:hover > a,
    .page-tabs .nav-tabs > li:focus > a {
        border-color: #ddd;
    }
    .page-tabs .nav-tabs > li.active > a,
    .page-tabs .nav-tabs > li.active > a:hover,
    .page-tabs .nav-tabs > li.active > a:focus {
        color: #666;
        font-weight: 600;
        background-color: #eee;
        border-bottom-color: transparent;
    }
    @media (max-width: 800px) {
        .page-tabs {
            padding: 25px 20px 0;
        }
        .page-tabs .nav-tabs li {
            float: none;
            margin-bottom: 5px;
        }
        .page-tabs .nav-tabs li:last-child,
        .page-tabs .nav-tabs li.active:last-child {
            margin-bottom: 10px;
        }
        .page-tabs .nav-tabs > li > a:hover,
        .page-tabs .nav-tabs > li > a:focus {
            border: 1px solid #DDD;
        }
        .page-tabs .nav-tabs > li.active > a,
        .page-tabs .nav-tabs > li.active > a:hover,
        .page-tabs .nav-tabs > li.active > a:focus {
            border-bottom-color: #ddd;
        }
    }
    .panel {
        position: relative;
        margin-bottom: 27px;
        background-color: rgba(255, 255, 255, 0.70) !important;
        border-radius: 3px;
    }
    .panel.panel-transparent {
        background: none;
        border: 0;
        margin: 0;
        padding: 0;
    }
    .panel.panel-border {
        border-style: solid;
        border-width: 0;
    }
    .panel.panel-border.top {
        border-top-width: 5px;
    }
    .panel.panel-border.right {
        border-right-width: 5px;
    }
    .panel.panel-border.bottom {
        border-bottom-width: 5px;
    }
    .panel.panel-border.left {
        border-left-width: 5px;
    }
    .panel.panel-border > .panel-heading {
        background-color: #fafafa;
        border-color: #e2e2e2;
        border-top: 1px solid transparent;
    }
    .panel.panel-border > .panel-heading > .panel-title {
        color: #999999;
    }
    .panel.panel-border.panel-default {
        border-color: #DDD;
    }
    .panel.panel-border.panel-default > .panel-heading {
        border-top: 1px solid transparent;
    }
    .panel-menu {
        background-color: #fafafa;
        padding: 12px;
        border: 1px solid #e2e2e2;
    }
    .panel-menu.dark {
        background-color: #f8f8f8;
    }
    .panel-body .panel-menu {
        border-left: 0;
        border-right: 0;
    }
    .panel-heading + .panel-menu,
    .panel-menu + .panel-body,
    .panel-body + .panel-menu,
    .panel-body + .panel-body {
        border-top: 0;
    }
    .panel-body {
        position: relative;
        padding: 15px;
        border: 1px solid #e2e2e2;
    }
    .panel-body + .panel-footer {
        border-top: 0;
    }
    .panel-heading {
        position: relative;
        height: 52px;
        line-height: 49px;
        letter-spacing: 0.2px;
        color: black;
        font-size: 15px;
        font-weight: 400;
        padding: 0 8px;
        background-color: var(--col)!important;
        border: 1px solid #e2e2e2;
        border-top-right-radius: 3px;
        border-top-left-radius: 3px;
    }
    .panel-heading + .panel-body {
        border-top: 0;
    }
    .panel-heading > .dropdown .dropdown-toggle {
        color: inherit;
    }
    .panel-heading .widget-menu .btn-group {
        margin-top: -3px;
    }
    .panel-heading .widget-menu .form-control {
        margin-top: 6px;
        font-size: 11px;
        height: 27px;
        padding: 2px 10px;
        border-radius: 1px;
    }
    .panel-heading .widget-menu .form-control.input-sm {
        margin-top: 9px;
        height: 22px;
    }
    .panel-heading .widget-menu .progress {
        margin-top: 11px;
        margin-bottom: 0;
    }
    .panel-heading .widget-menu .progress-bar-lg {
        margin-top: 10px;
    }
    .panel-heading .widget-menu .progress-bar-sm {
        margin-top: 15px;
    }
    .panel-heading .widget-menu .progress-bar-xs {
        margin-top: 17px;
    }
    .panel-icon {
        padding-left: 5px;
    }
    .panel-title {
        padding-left: 6px;
        margin-top: 0;
        margin-bottom: 0;
    }
    .panel-title > .fa,
    .panel-title > .glyphicon,
    .panel-title > .glyphicons,
    .panel-title > .imoon {
        top: 2px;
        min-width: 22px;
        color: inherit;
        font-size: 14px;
    }
    .panel-title > a {
        color: inherit;
    }
    .panel-footer {
        padding: 10px 15px;
        background-color: #fafafa;
        border: 1px solid #e2e2e2;
        border-bottom-right-radius: 2px;
        border-bottom-left-radius: 2px;
    }
    .panel > .list-group {
        margin-bottom: 0;
    }
    .panel > .list-group .list-group-item {
        border-radius: 0;
    }
    .panel > .list-group:first-child .list-group-item:first-child {
        border-top-right-radius: 2px;
        border-top-left-radius: 2px;
    }
    .panel > .list-group:last-child .list-group-item:last-child {
        border-bottom-right-radius: 2px;
        border-bottom-left-radius: 2px;
    }
    .panel-heading + .list-group .list-group-item:first-child {
        border-top-width: 0;
    }
    .panel-body + .list-group .list-group-item:first-child {
        border-top-width: 0;
    }
    .list-group + .panel-footer {
        border-top-width: 0;
    }
    .panel > .table,
    .panel > .table-responsive > .table,
    .panel > .panel-collapse > .table {
        margin-bottom: 0;
    }
    .panel > .table:first-child,
    .panel > .table-responsive:first-child > .table:first-child {
        border-top-right-radius: 2px;
        border-top-left-radius: 2px;
    }
    .panel > .table:first-child > thead:first-child > tr:first-child td:first-child,
    .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child td:first-child,
    .panel > .table:first-child > tbody:first-child > tr:first-child td:first-child,
    .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child td:first-child,
    .panel > .table:first-child > thead:first-child > tr:first-child th:first-child,
    .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child th:first-child,
    .panel > .table:first-child > tbody:first-child > tr:first-child th:first-child,
    .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child th:first-child {
        border-top-left-radius: 2px;
    }
    .panel > .table:first-child > thead:first-child > tr:first-child td:last-child,
    .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child td:last-child,
    .panel > .table:first-child > tbody:first-child > tr:first-child td:last-child,
    .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child td:last-child,
    .panel > .table:first-child > thead:first-child > tr:first-child th:last-child,
    .panel > .table-responsive:first-child > .table:first-child > thead:first-child > tr:first-child th:last-child,
    .panel > .table:first-child > tbody:first-child > tr:first-child th:last-child,
    .panel > .table-responsive:first-child > .table:first-child > tbody:first-child > tr:first-child th:last-child {
        border-top-right-radius: 2px;
    }
    .panel > .table:last-child,
    .panel > .table-responsive:last-child > .table:last-child {
        border-bottom-right-radius: 2px;
        border-bottom-left-radius: 2px;
    }
    .panel > .table:last-child > tbody:last-child > tr:last-child td:first-child,
    .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child td:first-child,
    .panel > .table:last-child > tfoot:last-child > tr:last-child td:first-child,
    .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child td:first-child,
    .panel > .table:last-child > tbody:last-child > tr:last-child th:first-child,
    .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child th:first-child,
    .panel > .table:last-child > tfoot:last-child > tr:last-child th:first-child,
    .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child th:first-child {
        border-bottom-left-radius: 2px;
    }
    .panel > .table:last-child > tbody:last-child > tr:last-child td:last-child,
    .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child td:last-child,
    .panel > .table:last-child > tfoot:last-child > tr:last-child td:last-child,
    .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child td:last-child,
    .panel > .table:last-child > tbody:last-child > tr:last-child th:last-child,
    .panel > .table-responsive:last-child > .table:last-child > tbody:last-child > tr:last-child th:last-child,
    .panel > .table:last-child > tfoot:last-child > tr:last-child th:last-child,
    .panel > .table-responsive:last-child > .table:last-child > tfoot:last-child > tr:last-child th:last-child {
        border-bottom-right-radius: 2px;
    }
    .panel > .panel-body + .table,
    .panel > .panel-body + .table-responsive {
        border-top: 1px solid #eeeeee;
    }
    .panel > .table > tbody:first-child > tr:first-child th,
    .panel > .table > tbody:first-child > tr:first-child td {
        border-top: 0;
    }
    .panel > .table-bordered,
    .panel > .table-responsive > .table-bordered {
        border: 0;
    }
    .panel > .table-bordered > thead > tr > th:first-child,
    .panel > .table-responsive > .table-bordered > thead > tr > th:first-child,
    .panel > .table-bordered > tbody > tr > th:first-child,
    .panel > .table-responsive > .table-bordered > tbody > tr > th:first-child,
    .panel > .table-bordered > tfoot > tr > th:first-child,
    .panel > .table-responsive > .table-bordered > tfoot > tr > th:first-child,
    .panel > .table-bordered > thead > tr > td:first-child,
    .panel > .table-responsive > .table-bordered > thead > tr > td:first-child,
    .panel > .table-bordered > tbody > tr > td:first-child,
    .panel > .table-responsive > .table-bordered > tbody > tr > td:first-child,
    .panel > .table-bordered > tfoot > tr > td:first-child,
    .panel > .table-responsive > .table-bordered > tfoot > tr > td:first-child {
        border-left: 0;
    }
    .panel > .table-bordered > thead > tr > th:last-child,
    .panel > .table-responsive > .table-bordered > thead > tr > th:last-child,
    .panel > .table-bordered > tbody > tr > th:last-child,
    .panel > .table-responsive > .table-bordered > tbody > tr > th:last-child,
    .panel > .table-bordered > tfoot > tr > th:last-child,
    .panel > .table-responsive > .table-bordered > tfoot > tr > th:last-child,
    .panel > .table-bordered > thead > tr > td:last-child,
    .panel > .table-responsive > .table-bordered > thead > tr > td:last-child,
    .panel > .table-bordered > tbody > tr > td:last-child,
    .panel > .table-responsive > .table-bordered > tbody > tr > td:last-child,
    .panel > .table-bordered > tfoot > tr > td:last-child,
    .panel > .table-responsive > .table-bordered > tfoot > tr > td:last-child {
        border-right: 0;
    }
    .panel > .table-bordered > thead > tr:first-child > td,
    .panel > .table-responsive > .table-bordered > thead > tr:first-child > td,
    .panel > .table-bordered > tbody > tr:first-child > td,
    .panel > .table-responsive > .table-bordered > tbody > tr:first-child > td,
    .panel > .table-bordered > thead > tr:first-child > th,
    .panel > .table-responsive > .table-bordered > thead > tr:first-child > th,
    .panel > .table-bordered > tbody > tr:first-child > th,
    .panel > .table-responsive > .table-bordered > tbody > tr:first-child > th {
        border-bottom: 0;
    }
    .panel > .table-bordered > tbody > tr:last-child > td,
    .panel > .table-responsive > .table-bordered > tbody > tr:last-child > td,
    .panel > .table-bordered > tfoot > tr:last-child > td,
    .panel > .table-responsive > .table-bordered > tfoot > tr:last-child > td,
    .panel > .table-bordered > tbody > tr:last-child > th,
    .panel > .table-responsive > .table-bordered > tbody > tr:last-child > th,
    .panel > .table-bordered > tfoot > tr:last-child > th,
    .panel > .table-responsive > .table-bordered > tfoot > tr:last-child > th {
        border-bottom: 0;
    }
    .panel > .table-responsive {
        border: 0;
        margin-bottom: 0;
    }
    .panel-group {
        margin-bottom: 19px;
    }
    .panel-group .panel-title {
        padding-left: 0;

    }
    .panel-group .panel-heading,
    .panel-group .panel-heading a {
        position: relative;
        display: block;
        width: 100%;
    }
    .panel-group.accordion-lg .panel + .panel {
        margin-top: 12px;
    }
    .panel-group.accordion-lg .panel-heading {
        font-size: 14px;
        height: 54px;
        line-height: 52px;
    }
    .panel-group .accordion-icon {
        padding-left: 35px;
    }
    .panel-group .accordion-icon:after {
        position: absolute;
        content: "\f068";
        font-family: "FontAwesome";
        font-size: 12px;
        font-style: normal;
        font-weight: normal;
        -webkit-font-smoothing: antialiased;
        color: #555;
        left: 10px;
        top: 0;
    }
    .panel-group .accordion-icon.collapsed:after {
        content: "\f067";
    }
    .panel-group .accordion-icon.icon-right {
        padding-left: 10px;
        padding-right: 30px;
    }
    .panel-group .accordion-icon.icon-right:after {
        left: auto;
        right: 5px;
    }
    .panel-group .panel {
        margin-bottom: 0;
        border-radius: 3px;
    }
    .panel-group .panel + .panel {
        margin-top: 5px;
    }
    .panel-group .panel-heading + .panel-collapse > .panel-body {
        border-top: 0;
    }
    .panel-group .panel-footer {
        border-top: 0;
    }
    .panel-group .panel-footer + .panel-collapse .panel-body {
        border-bottom: 1px solid #eeeeee;
    }


    .media {
        color: #999999;
        font-weight: 600;
        margin-top: 15px;
    }
    .media:first-child {
        margin-top: 0;
    }
    .media-right,
    .media > .pull-right {
        padding-left: 10px;
    }
    .media-left,
    .media > .pull-left {
        padding-right: 10px;
    }
    .media-left,
    .media-right,
    .media-body {
        display: table-cell;
        vertical-align: top;
    }
    .media-middle {
        vertical-align: middle;
    }
    .media-bottom {
        vertical-align: bottom;
    }
    .media-heading {
        color: black;
        margin-top: 0;
        margin-bottom: 5px;
    }

    .meding {
        color: black;
        margin-top: 35px;
        margin-bottom: 5px;
    }
    .media-list {
        padding-left: 0;
        list-style: none;
    }

    /*===============================================
      Tabs
    ================================================= */
    /* Tabs Wrapper */
    .tab-block {
        position: relative;
    }
    /* Tabs Content */
    .tab-block .tab-content {
        overflow: auto;
        position: relative;
        z-index: 10;
        min-height: 125px;
        padding: 16px 12px;
        border: 1px solid #e2e2e2;
        background-color: rgba(255, 255, 255, 0.70);
    }
    /*===============================================
      Tab Navigation
    ================================================= */
    .tab-block .nav-tabs {
        position: relative;
        border: 0;
    }
    /* nav tab item */
    .tab-block .nav-tabs > li {
        float: left;
        margin-bottom: -1px;
    }
    /* nav tab link */
    .tab-block .nav-tabs > li > a {
        z-index: 9;
        position: relative;
        color: #AAA;
        font-size: 14px;
        font-weight: 400;
        padding: 14px 20px;
        margin-right: -1px;
        border-color: #e2e2e2;
        border-radius: 0;
        background: #fafafa;
    }
    .tab-block .nav-tabs > li:first-child > a {
        margin-left: 0;
    }
    /* nav tab link:hover */
    .tab-block .nav-tabs > li > a:hover {
        background-color: #f4f4f4;
    }
    /* nav tab active link:focus:hover */
    .tab-block .nav-tabs > li.active > a,
    .tab-block .nav-tabs > li.active > a:hover,
    .tab-block .nav-tabs > li.active > a:focus {
        cursor: default;
        position: relative;
        z-index: 12;
        color: #2f2f2f;
        background: rgba(255, 255, 255, 0.67);
    }
    /*===============================================
      Tab Navigation - Tabs Left
    ================================================= */
    .tabs-left {
        float: left;
    }
    /* nav tab item */
    .tabs-left > li {
        float: none;
        margin: 0 -1px -1px 0;
    }
    /* nav tab item link */
    .tabs-left > li > a {
        padding: 14px 16px;
        color: #777;
        font-weight: 600;
        border: 1px solid transparent;
        border-color: #DDD;
        background: #fafafa;
    }
    /* nav tab link:hover */
    /* nav tab active link:focus:hover */
    .tab-block .tabs-left > li.active > a,
    .tab-block .tabs-left > li.active > a:hover,
    .tab-block .tabs-left > li.active > a:focus {
        color: #555;
        border-color: #DDD #FFF #DDD #DDD;
        cursor: default;
        position: relative;
        z-index: 12;
        background: #FFF;
    }
    /*===============================================
      Tab Navigation - Tabs Right
    ================================================= */
    .tabs-right {
        float: right;
    }
    /* nav tab item */
    .tabs-right > li {
        float: none;
        margin: 0 0 -1px -1px;
    }
    /* nav tab item link */
    .tabs-right > li > a {
        padding: 14px 16px;
        color: #777;
        font-weight: 600;
        border: 1px solid transparent;
        border-color: #DDD;
        background: #fafafa;
    }
    /* nav tab link:hover */
    /* nav tab active link:focus:hover */
    .tab-block .tabs-right > li.active > a,
    .tab-block .tabs-right > li.active > a:hover,
    .tab-block .tabs-right > li.active > a:focus {
        color: #555;
        border-color: #DDD #DDD #DDD #FFF;
        cursor: default;
        position: relative;
        z-index: 12;
        background: #FFF;
    }
    /*===============================================
      Tab Navigation - Tabs Right
    ================================================= */
    .tabs-below {
        position: relative;
    }
    /* nav tab item */
    .tabs-below > li {
        float: left;
        margin-top: -1px;
    }
    /* nav tab item link */
    .tabs-below > li > a {
        position: relative;
        z-index: 9;
        margin-right: -1px;
        padding: 11px 16px;
        color: #777;
        font-weight: 600;
        border: 1px solid #DDD;
        background: #fafafa;
    }
    /* nav tab link:hover */
    /* nav tab active link:focus:hover */
    .tab-block .tabs-below > li.active > a,
    .tab-block .tabs-below > li.active > a:hover,
    .tab-block .tabs-below > li.active > a:focus {
        cursor: default;
        position: relative;
        z-index: 12;
        color: #555555;
        background: #FFF;
        border-color: #DDD;
        border-top: 1px solid #FFF;
    }

    h2 small{
        color: white !important;
    }
    .message_me{
        margin-top: 20px!important;
    }
    .butt{
        padding: 10px 5px;
        font-size: 17px;
    }
</style>

<style>
    @media only screen and (max-width: 991px) {
        .message_me{
            margin-top: 20px!important;
        }

    }
</style>
@section('content')

    <section id="content" class="container">
        <!-- Begin .page-heading -->
        <div class="page-heading">
            <div class="media clearfix">
                <div class="row">
                    <div class="col-md-2">
                        <div class="pr10" style="background-image: url('{{$user_seller->photo == null ? Helper::userDefaultImage() : $user_seller->photo}}');
                            height: 120px;
                            width: 120px;
                            border-radius: 5%;
                            background-size: cover;
                        ">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="media-body va-m">
                            @php
                                $name = explode( " ", $user_seller->username)
                            @endphp
                            <h2 class="{{$user_seller->seller ? 'media-heading' : 'meding'}}">{{$name[0]}}'s
                                <small> - {{$user_seller->seller ? 'SHOP' : 'Profile'}}</small>
                            </h2>
                        </div>
                        @if($user_seller->seller)
                        <div class="message_me col-md-3">
                            @if($user)
                                @if($user->user_id != $user_seller->user_id)
                                    <a href="{{route('message.show', $user_seller->user_id)}}" title="message">
                                        <button class="btn butt btn-success"> <i class="fa fa-inbox p-2" style="font-size: 18px!important;"> </i> Message me</button>
                                    </a>
                                @endif
                            @else
                                <a href="{{route('user.auth')}}" title="message">
                                    <button class="btn btn-success"> <i class="fa fa-inbox fs20 p-2">  </i> Message me</button>
                                </a>
                            @endif
                        </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">

                <div class="panel">
                    <div class="panel-heading">
                  <span class="panel-icon">
                    <i class="fa fa-shekel"></i>
                  </span>
                        <span class="panel-title">{{$user_seller->username}}'s stats</span>
                    </div>
                    <div class="panel-body pb5">

                        <h5> Successful order ({{count($orders)}})</h5>

                        <hr class="short br-lighter">
                        <h5><a href="#tab2" data-toggle="tab"> Total feedback ({{\App\Models\UserReview::where('reviewed', $user_seller->user_id)->count()}}) </a></h5>

                        <hr class="short br-lighter">
                        @php
                            $date = explode(' ', $user_seller->created_at)
                        @endphp

                        <h5> Member since  :  {{$date[0]}}</h5>


                    </div>
                </div>
            </div>
            <div class="col-md-8">

                <div class="tab-block">
                    <ul class="nav nav-tabs">
                        @if($user_seller->seller)
                        <li class="active">
                            <a href="#tab1" data-toggle="tab">Browse shop ({{$products->count()}})</a>
                        </li>
                        @endif
                        <li>
                            @php
                                $usr = explode(':', $user_seller->user_id);
                            @endphp
                            <a href="#tab2" data-toggle="tab"> {{ $user_seller->seller ? 'Buyer' : 'Seller' }}'s feedback ({{\App\Models\UserReview::where('reviewed', $user_seller->user_id)->count()}})</a>
                        </li>
                    </ul>
                    <div class="tab-content p30" style="height: 700px; margin-bottom: 30px">
                        @if($user_seller->seller)
                        <div id="tab1" class="tab-pane active">
                            <div class="table-responsive" >
                                <table class="table table-sm table-striped" id="dtBasicExample">

                                    <thead>
                                    <tr>
                                        <th>Offer title</th>
                                        <th>Game</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Details</th>
                                    </tr>
                                    </thead>

                                    @foreach($products as $item)
                                        <tbody>
                                        <tr style="background-color: rgba(255, 255, 255, 0.05)">
                                            <td>
                                                <p>{{ucfirst($item->summary)}}</p>
                                            </td>

                                            <td>
                                                <p>{{ucfirst(\App\Models\Brand::where('id', $item->brand_id)->first()->title)}}</p>
                                            </td>

                                            <td>
                                                <p>{{ucfirst(\App\Models\Category::where('id', $item->cat_id)->first()->title)}}</p>
                                            </td>

                                            <td>
                                                {{Helper::currency_converter($item->offer_price)}}<br/>
                                            </td>

                                            <td>
                                                <a href="{{route('product.detail', $item->slug)}}" class="btn btn-success">Details</a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endforeach

                                </table>
                            </div>
                        </div>
                        @endif
                        <div id="tab2" class="tab-pane {{$user_seller->seller ? '' : 'active'}}">
                            <div class="tab-content-item " id="review">
                               <div class="card" style="margin-bottom: 25px; border: none; background-color: rgba(255, 255, 255, 0.01)">
                                   <div class="row">
                                       <div class="col-12 text-center">
                                           <h3>Rating Overview</h3>
                                       </div>
                                       <div class=" col-12 text-center">
                                           <h1>{{number_format($user_seller->avg_rating, 1)}}<small>/5</small></h1>
                                       </div>
                                       <div class=" col-12 text-center">
                                               @php
                                                   $rating = $user_seller->avg_rating;
                                               @endphp
                                               @foreach(range(1,5) as $i)
                                                   <span class="fa-stack" style="width:12px">
                                            <i class="far fa-star fa-stack-1x"></i>
                                            @if($rating >0)
                                                           @if($rating >0.5)
                                                               <i class="fas fa-star fa-stack-1x" style="color:  #F7D708;"></i>
                                                           @else
                                                               <i class="fas fa-star-half fa-stack-1x" style="font-size: 12px; color: #F7D708;"></i>
                                                           @endif
                                                       @endif
                                                       @php $rating--; @endphp
                                        </span>
                                               @endforeach


                                           <p>{{\App\Models\UserReview::where('reviewed', $user_seller->user_id)->count()}} ratings</p>
                                       </div>

                                   </div>

                               </div >
                                <hr/>

                                <div class="wrap-review-form">
                                        @php
                                            $reviews = \App\Models\UserReview::where('reviewed', $user_seller->user_id)->latest()->paginate(4);
                                        @endphp
                                    <div id="comments">
                                        @if(count($reviews)>0)
                                            @foreach($reviews as $key=>$review)

                                                @php
                                                    $reviewer = \App\Models\User::where('user_id', $review->reviewer)->first();
                                                @endphp
                                                <h2 class="woocommerce-Reviews-title">{{$key+1}} review from <span>{{ucfirst($reviewer->username)}}</span></h2>
                                                <ol class="commentlist">
                                                    <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-20">
                                                        <div id="comment-20" class="row comment_container">
                                                            <div class="col-3" style="background-image: url('{{$reviewer->photo == null ? Helper::userDefaultImage() : $reviewer->photo}}');
                                                                background-size: cover; height: 75px; max-width: 75px; border-radius: 50%; float: left">
                                                            </div>
                                                            <div class="comment-text col-9">
                                                                <div class="">
                                                                    @for($i=0; $i < 5; $i++)
                                                                        @if($review->rate > $i)
                                                                            <i class="fa fa-star" style="color: gold" araia-hidden="true"></i>
                                                                        @else
                                                                            <i class="fa fa-star" araia-hidden="true" style="color: #efefef"> </i>
                                                                        @endif

                                                                    @endfor

                                                                </div>
                                                                <p class="meta">
                                                                    <strong class="woocommerce-review__author">{{\App\Models\User::where('id', $review->user_id)->value('username')}}</strong>
                                                                    <span class="woocommerce-review__dash">–</span>
                                                                    <time class="woocommerce-review__published-date" datetime="2008-02-14 20:00" >{{\Carbon\Carbon::parse($review->created_at)->format('M, d Y')}}</time>
                                                                </p>
                                                                <div class="description">
                                                                    <p style="font-size: 15px;">{{$review->review}}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ol>
                                            @endforeach
                                        @endif
                                        {{$reviews->links('vendor.pagination.default')}}
                                    </div>


                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">
                                                @if(!count($reviews)>0)
                                                    <h6 class="text-center text-behance"> No reviews yet</h6>
                                                @endif


                                            </div><!-- .comment-respond-->
                                        </div><!-- #review_form -->
                                    </div><!-- #review_form_wrapper -->

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function () {
            $('#dtBasicExample').DataTable();
            $('.dataTables_length').addClass('bs-select');
        });
    </script>
@endsection
