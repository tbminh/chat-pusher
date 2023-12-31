@extends('layouts.app')
@section('content')
    <style>
        body {
            margin-top: 20px;
        }

        .chat-online {
            color: #34ce57
        }

        .chat-offline {
            color: #e4606d
        }

        .chat-messages {
            display: flex;
            flex-direction: column;
            max-height: 800px;
            overflow-y: scroll
        }

        .chat-message-left,
        .chat-message-right {
            display: flex;
            flex-shrink: 0;
            flex-direction: column;
        }

        .chat-message-left {
            margin-right: auto
        }

        .chat-message-right {
            align-items: end;
            margin-left: auto
        }

        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .px-4 {
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
        }

        .flex-grow-0 {
            flex-grow: 0 !important;
        }

        .border-top {
            border-top: 1px solid #dee2e6 !important;
        }
    </style>
    <main class="content">
        <div class="container p-0">
            <div class="card">
                <div class="row g-0" id="search-vue">


                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
