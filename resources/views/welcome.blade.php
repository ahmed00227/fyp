@foreach ($groupedMessages as $date => $messages)
    <div class="text-center my-4">
        <span class="chat-date">{{$date}}</span>
    </div>
    @foreach ($messages as $message)
        <!--begin::Message(in)-->
        @if(!in_array($message->deleted_by, $teamIds))
            <div
                class="d-flex mb-10  {{in_array($message->user_id, $teamIds) ? 'justify-content-end'  : 'justify-content-start'}}">
                <!--begin::Wrapper-->
                <div
                    class="d-flex flex-column   {{in_array($message->user_id, $teamIds) ? 'align-items-end'  : 'align-items-start'}}">
                    <!--begin::Text-->
                    @if(isset($message->offer))
                        <div
                            class="d-flex justify-content-{{ in_array($message->user_id, $teamIds) ? 'end' : 'start' }}">
                            <div class="card mb-3 col-sm-4 col-md-12 col-lg-8 ad-share responsive-chat offer-card-user"
                                 id="offerCard-{{ $message->offer_id }}"
                                 style="height: fit-content !important; border: 16px solid {{ in_array($message->user_id, $teamIds) ? '#FFEAD1' : '#4273B9' }} !important;">
                                <img src="{{ url('/storage/ad/images/' . $message->offer->image) }}"
                                     class="card-img-top ads-card-img" alt="Ad Image"
                                     style="height:195px;"/>
                                <div
                                    class="card-body d-sm-flex align-items-center justify-content-between col-12"
                                    style="padding: 5px 15px;">
                                    <div class="col-12 col-md-7 col-lg-7">
                                        <h5 class="card-title text-truncate msg-text msg-text-2 fw-bold"
                                            style="color: #45464E;">{{ $message->offer->title }}</h5>
                                    </div>
                                    <div
                                        class="me-2 d-lg-flex flex-row-reverse mt-2 text-pink bold col-lg-5 col-12 d-block"
                                        style="font-weight: 600; font-size: 18px; font-family: 'Noto Sans SC';">
                                        <p class="card-price text-truncate fs-15">{{ $message->offer->currency . ' ' . $message->offer->price }}</p>
                                    </div>
                                </div>
                                <hr class="mx-4"
                                    style="border: 1px solid #F1F1F1; margin: 0px;">
                                <p class="mx-3"
                                   style="color: #606266; font-size: 14px;">{{ $message->offer->description }}</p>
                                <div class="mx-3 d-lg-flex d-md-flex col-12">
                                    <div class="col-4">
                                        <p class="font-expiry-delivery">Delivery Date</p>
                                        <p class="mx-1" style="color: #606266; font-size: 14px;">
                                            {{ $message->offer->delivery_date ?? '---' }}
                                        </p>
                                    </div>
                                    <div class="col-8">
                                        <p class="font-expiry-delivery">Expiry Date</p>
                                        <p style="color: #606266; font-size: 14px;">{{ $message->offer->expiry_date}}</p>
                                    </div>
                                </div>
                                @if($message->action)
                                    <div class=" d-flex mb-2 px-3 " id="offer-action-{{$message->id}}">
                                        <button type="button"
                                                class="rounded my-2 py-2 w-100 "
                                                style="border: 1px solid #DCDFE6; font-size: 16px;">
                                            @if($message->action=='accept')
                                                Offer Accepted
                                            @elseif($message->action=='reject')
                                                Offer Rejected
                                            @elseif($message->action=='withdrawn')
                                                Offer Withdrawn
                                            @elseif($message->action=='closed')
                                                Offer Closed
                                            @elseif($message->action=='expired')
                                                Offer Expired
                                            @elseif($message->action=='counter')
                                                Offer Countered
                                            @endif
                                        </button>
                                    </div>
                                @else
                                    @if (in_array($message->user_id, $teamIds))
                                        <div class=" d-flex mb-2 px-3 " id="offer-action-{{$message->id}}">
                                            <button type="button"
                                                    class="rounded my-2 py-2 w-100 "
                                                    style="border: 1px solid #DCDFE6; font-size: 16px;">
                                                Pending
                                            </button>
                                        </div>
                                    @else
                                        <button type="button"
                                                class="btn bg-light mx-2 accept-offer"
                                                id="accept-offer-{{ $message->id }}"
                                                data-offer-id="{{ $message->offer_id }}"
                                                style="border: 1px solid #DCDFE6">
                                            Accept
                                        </button>
                                        <button type="button"
                                                class="btn text-white bg-pink reject-offer"
                                                id="reject-offer-{{$message->id }}"
                                                data-offer-id="{{ $message->offer_id }}"
                                                data-id="{{ $message->id }}">
                                            Reject
                                        </button>
                                        @if ($chat->chat_type=='dealer-consumer')
                                            <div class="ms-auto">
                                                @if()
                                                    @php
                                                        $offerAd = $message->messageAd ?? $chat->ad;
                                                    @endphp
                                                    <button
                                                        class="text-white px-2 card-price bg-pink rounded py-2 border-0 respond counter-offer"
                                                        id="counterOffer-{{ $offerAd->id }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#counterModal"
                                                        data-ad-image="{{ $offerAd->primary_avatar }}"
                                                        data-prev-offer-id="{{ $message->offer_id }}"
                                                        data-offer-delivery="{{ $message->offer->delivery_date ?? null }}"
                                                        data-offer-expiry="{{ $message->offer->expiry_date ?? null }}"
                                                        data-offer-description="{{ $message->offer->description ?? null }}"
                                                        data-ad-title="{{ $message->offer->title }}"
                                                        data-ad-price="{{ $message->offer->price }}"
                                                        data-ad-id="{{ $offerAd->id }}"
                                                        data-msg-ad-id="{{ $message->message_ad_id }}"
                                                        data-ad-car-name="{{ $offerAd->car_name }}"
                                                        data-ad-mileage="{{ $offerAd->mileage . $offerAd->mileage_type }}"
                                                        data-ad-year="{{ $offerAd->model_year }}"
                                                        data-ad-make="{{ $offerAd->make }}"
                                                        data-ad-model="{{ $offerAd->model }}"
                                                        data-source="counter_offer">
                                                        Counter Offer
                                                    </button>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    @elseif($message->messageAd)

                    @endif

                    @if(isset($message->avatar))
                        @if(in_array(pathinfo($message->avatar, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp','PNG','JPG','JPEG','GIF']))
                            <div
                                class="card border-0 position-relative mb-5 {{$message->user_id == Auth::user()->id ? 'text-start dealer-text-2'  : 'text-start dealer-text-1'}}">
                                <div class="card-body p-0">
                                    <a class="{{$message->user_id == Auth::user()->id ? 'text-black msgAnchora'  : 'text-white msgAnchorb'}}"
                                       href="{{url('/storage/ad/message/'.$message->avatar)}}"
                                       download>
                                        <div class="msg-box-img mb-4 mt-4"
                                             style="background-image: url('{{ url('/storage/ad/message/' . $message->avatar) }}');"></div>
                                    </a>
                                </div>
                                <p class="mb-0 position-absolute {{$message->user_id == Auth::user()->id ? 'msg-time-right'  : 'msg-time-left'}}">
                                    {{$message->created_at->format('H:i')}}</p>
                                <span
                                    class="send-tick position-absolute {{$message->user_id == Auth::user()->id ? 'msg-tick-right'  : 'msg-tick-left'}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                         height="12" viewBox="0 0 12 12" fill="none">
                                                                    <g id="fi:check">
                                                                    <path id="Vector" d="M10 3L4.5 8.5L2 6"
                                                                          stroke="#1C1D22" stroke-width="2"
                                                                          stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                    </g>
                                                                    </svg>
                                                                    </span>
                            </div>
                        @else
                            <div
                                class="card border-0 position-relative mb-5 {{$message->user_id == Auth::user()->id ? 'text-start dealer-text-2'  : 'text-start dealer-text-1'}}">
                                <div class="card-body p-0">
                                    <a class="{{$message->user_id == Auth::user()->id ? 'text-black msgAnchora'  : 'text-white msgAnchorb'}}"
                                       href="{{url('/storage/ad/message/'.$message->avatar)}}"
                                       download>{{$message->avatar}}</a>
                                </div>
                                <p class="mb-0 position-absolute {{$message->user_id == Auth::user()->id ? 'msg-time-right'  : 'msg-time-left'}}">
                                    {{$message->created_at->format('H:i')}}</p>
                                <span
                                    class="send-tick position-absolute {{$message->user_id == Auth::user()->id ? 'msg-tick-right'  : 'msg-tick-left'}}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                     height="12" viewBox="0 0 12 12" fill="none">
                                                                    <g id="fi:check">
                                                                    <path id="Vector" d="M10 3L4.5 8.5L2 6"
                                                                          stroke="#1C1D22" stroke-width="2"
                                                                          stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                            </div>
                        @endif
                    @endif
                    @if(isset($message->message))
                        <div
                            class="card border-0 position-relative mb-5 {{$message->user_id == Auth::user()->id ? 'text-start dealer-text-2'  : 'text-start dealer-text-1'}}">
                            <div class="card-body p-0">
                                <div
                                    class="msg-text msg-path font-22"
                                    data-kt-element="message-text">{{$message->message}}</div>
                            </div>
                            <p class="mb-0 position-absolute {{$message->user_id == Auth::user()->id ? 'msg-time-right'  : 'msg-time-left'}}">
                                {{$message->created_at->format('H:i')}}</p>
                            <span
                                class="send-tick position-absolute {{$message->user_id == Auth::user()->id ? 'msg-tick-right'  : 'msg-tick-left'}}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                                     height="12" viewBox="0 0 12 12" fill="none">
                                                                    <g id="fi:check">
                                                                    <path id="Vector" d="M10 3L4.5 8.5L2 6"
                                                                          stroke="#1C1D22" stroke-width="2"
                                                                          stroke-linecap="round"
                                                                          stroke-linejoin="round"/>
                                                                    </g>
                                                                </svg>
                                                            </span>
                        </div>
                    @endif
                    @if (isset($message->message_ad_id) && $message->offer_id==null)
                        @php
                            $messageAd=Ad::find($message->message_ad_id)
                        @endphp
                        <div class="chat-container" id="chat-container">
                            <!-- Chat messages and ad cards will be rendered here -->
                            <div
                                class="card mb-3 col-sm-4 col-md-12 col-lg-8 float-lg-end ad-share responsive-chat"
                                style="border: 16px solid {{ $message->user_id === auth()->id() ? '#FFEAD1' : '#4273B9' }} !important; height: fit-content">
                                <img
                                    src="{{$message->ad_image }}"
                                    {{--                                                                            src="{{ asset('user/resources/images/Group 1000003970.png') }}"--}}
                                    class="card-img-top ads-card-img"
                                    alt="Ad Image"
                                    style="object-fit: contain; height:196px;">
                                <div
                                    class="card-body d-sm-flex align-items-center justify-content-between col-12"
                                    style="padding: 0px 15px;">
                                                                            <span class="col-8">
                                                                            <h5 class="card-title text-truncate msg-text msg-text-2 mt-2">{{ $message->ad_title }}</h5>
                                                                                </span>
                                    <span
                                        class="d-lg-flex d-block flex-row-reverse me-2 mt-3 text-pink bold col-12 col-lg-4"
                                        style="font-weight: 600; !important;">
                                                                            <p class="card-price text-truncate fs-15"
                                                                               style="">
                                                                                 {{ $message->ad_price }}</p>
                                                                                </span>
                                </div>
                                <hr class="mx-4"
                                    style="border: 1px solid #F1F1F1; margin: 0px;">
                                <div class="mx-3 mb-3 d-lg-flex d-md-flex">
                                    <div class="d-flex">
                                                                                <span class="me-2 chat-card-MLY"
                                                                                      style="margin-top: 2px">
                                                                                 <svg width="16" height="16"
                                                                                      viewBox="0 0 16 16" fill="none"
                                                                                      xmlns="http://www.w3.org/2000/svg"
                                                                                      xmlns:xlink="http://www.w3.org/1999/xlink"> <mask
                                                                                         id="mask0_1663_5144"
                                                                                         style="mask-type:alpha"
                                                                                         maskUnits="userSpaceOnUse"
                                                                                         x="0" y="0" width="16"
                                                                                         height="16"> <rect width="16"
                                                                                                            height="16"
                                                                                                            fill="url(#pattern0_1663_5144)"/> </mask> <g
                                                                                         mask="url(#mask0_1663_5144)"> <rect
                                                                                             width="16" height="16"
                                                                                             fill="#727273"/> </g> <defs> <pattern
                                                                                             id="pattern0_1663_5144"
                                                                                             patternContentUnits="objectBoundingBox"
                                                                                             width="1" height="1"> <use
                                                                                                 xlink:href="#image0_1663_5144"
                                                                                                 transform="scale(0.0078125)"/> </pattern> <image
                                                                                             id="image0_1663_5144"
                                                                                             width="128" height="128"
                                                                                             xlink:href="data:image/png;base64,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"/> </defs> </svg>
                                                                                </span>
                                        <span
                                            class="share-chat-card"><p>{{$message->ad_mileage.$message->ad_mileage_type}}</p></span>
                                    </div>
                                    <div class="d-flex">
                                        <img
                                            class="ms-md-4 col-0 me-2 chat-card-MLY"
                                            src="{{asset('user/resources/images/Mask group (2).png')}}"
                                            alt=""><span
                                            class="share-chat-card"><p>{{$message->ad_year}}</p></span>
                                    </div>
                                    @if(isset($messageAd))
                                        <div class="d-flex">
                                            <img
                                                class="ms-md-4 me-2 chat-card-MLY"
                                                src="{{asset('user/resources/images/Mask group (2).png')}}"
                                                alt=""><span
                                                class="share-chat-card"><p>{{$messageAd->body_type}}</p></span>
                                        </div>
                                    @endif
                                </div>
                                @if ($message->user && !$message->user->hasRole('dealer'))
                                    @if(auth()->user()->is_premium)
                                        @if($message->market_price)
                                            <div class="mx-3 mb-3">
                                                <p><strong>Average Market
                                                        Price: </strong>
                                                    RD$ {{$message->market_price}}
                                                </p>
                                            </div>
                                        @else
                                            <div class="mx-3 mb-3">
                                                <p><strong>Market price not
                                                        available </strong></p>
                                            </div>
                                        @endif
                                    @endif
                                    @php
                                        $messageCardAd= Ad::withoutGlobalScope(ExpiaryAd::class)->find($message->message_ad_id);
                                    @endphp
                                        <!-- Additional buttons for dealers -->
                                    @if($messageCardAd)
                                        @if($messageCardAd->date<=Carbon\Carbon::now()->subDays(40) && $messageCardAd->user->hasRole('user'))
                                            <div class="d-flex mb-2 px-3">
                                                <button type="button"
                                                        class="rounded my-2 py-2 w-100 pending-button-1"
                                                        style="border: 1px solid #DCDFE6; font-size: 16px;">
                                                    Ad Deactivated
                                                </button>
                                            </div>
                                        @else
                                            <div
                                                class="mx-3 mb-3 d-lg-flex d-md-flex">

                                                @php
                                                    $isMessageInMatchingMessages=null;
                                                    if($matchingMessages !=null){
                                                        $isMessageInMatchingMessages = $matchingMessages->contains('id', $message->id);
                                                   }
                                                    $deal = \App\Models\Deal::where('ad_id',$messageCardAd->id)->whereNotIn('status',['cancel','closed','unwind deal'])->count();
                                                @endphp
                                                @if(auth()->user()->is_premium)
                                                    <button
                                                        class="text-white px-2 card-price font-22 respond-buttons bg-pink {{$showRespondButton&&$deal==0&&!$messageCardAd->swapped? '' : 'disabled'}} {{$deal>0||$messageCardAd->swapped ? 'existing-deal': ''}} rounded py-2 border-0 respond-to-offer respond"
                                                        style="font-size: revert"
                                                        @if($deal>0||$messageCardAd->swapped)
                                                            disabled
                                                        title="Ad's Deal is inprogress"
                                                        @elseif(!$showRespondButton)
                                                            disabled
                                                        data-bs-toggle="tooltip"
                                                        title="Conclude previous deal to create another"
                                                        @else
                                                            data-bs-toggle="modal"
                                                        @endif

                                                        id="respondDeal-{{ $messageCardAd->id}}"
                                                        data-source="respond_deal"
                                                        data-bs-target="#exampleModal11"
                                                        data-ad-image="{{ $message->ad_image }}"
                                                        data-ad-title="{{ $message->ad_title }}"
                                                        data-ad-price="{{ $message->ad_price }}"
                                                        data-ad-id="{{ $message->ad_id }}"
                                                        data-msg-ad-id="{{ $messageCardAd->id}}"
                                                        data-ad-car-name="{{ $messageCardAd->car_name }}"
                                                        data-ad-primary-avatar="{{ $messageCardAd->primary_avatar }}"
                                                        data-ad-mileage="{{ $message->ad_mileage . $message->ad_mileage_type }}"
                                                        data-ad-year="{{ $message->ad_year }}"
                                                        data-ad-make="{{ $messageCardAd->make }}"
                                                        data-ad-model="{{ $messageCardAd->model }}"
                                                        data-receiver-id="{{ $message->user_id }}">
                                                        Respond to Deal
                                                    </button>
                                                @else
                                                    <a href="{{route('dealer.subscription_plan')}}"
                                                       title="Upgrade to a Premium Plan to continue managing deals."
                                                       class="btn border-0 create-a-deal font-22 ">Respond
                                                        to Deal</a>
                                                @endif
                                                <a href="{{ route('user.used.car.details.index', $messageCardAd->slug) }}"
                                                   target="_blank"
                                                   class="text-black px-2 card-price bg-white border border-secondary rounded py-2 mx-md-2 "
                                                   style="font-size: revert;">
                                                    <button
                                                        class="mt-lg-0 mt-md-0  mt-4 text-black bg-white border-0"
                                                        style="font-size: revert;">
                                                        View Ad
                                                    </button>
                                                </a>

                                            </div>
                                        @endif
                                    @else
                                        <div class="d-flex mb-2 px-3">
                                            <button type="button"
                                                    class="rounded my-2 py-2 w-100 pending-button-1"
                                                    style="border: 1px solid #DCDFE6; font-size: 16px;">
                                                Deleted Ad
                                            </button>
                                        </div>
                                    @endif

                                @endif

                            </div>
                            {{--                                                                    @php $adsShownInChat[] = $chatuser->id; @endphp--}}
                        </div>
                    @endif

                    <!--end::Text-->
                </div>
                <!--end::Wrapper-->
            </div>
            @if(isset($message->offer_id))
                <div class="d-flex justify-content-{{ $message->user_id === auth()->id() ? 'end' : 'start' }}">
                    <div
                        class="card mb-3 col-sm-4 col-md-12 col-lg-8 ad-share responsive-chat offer-card-user"
                        id="offerCard-{{ $message->offer_id }}"
                        style="height: fit-content !important; border: 16px solid {{ $message->user_id === auth()->id() ? '#FFEAD1' : '#4273B9' }} !important;">
                        <img
                            src="{{ url('/storage/ad/images/' . $message->offer_image) }}"
                            class="card-img-top ads-card-img" alt="Ad Image"
                            style="height:195px;"/>
                        <div
                            class="card-body d-sm-flex align-items-center justify-content-between col-12"
                            style="padding: 5px 15px;">
                            <div class="col-12 col-md-7 col-lg-7">
                                <h5 class="card-title text-truncate msg-text msg-text-2 fw-bold"
                                    style="color: #45464E;">{{ $message->offer_title }}</h5>
                            </div>
                            <div
                                class="me-2 d-lg-flex flex-row-reverse mt-2 text-pink bold col-lg-5 col-12 d-block"
                                style="font-weight: 600; font-size: 18px; font-family: 'Noto Sans SC';">
                                <p class="card-price text-truncate fs-15">{{ $message->offer_currency . ' ' . $message->offer_price }}</p>
                            </div>
                        </div>
                        <hr class="mx-4"
                            style="border: 1px solid #F1F1F1; margin: 0px;">
                        <p class="mx-3"
                           style="color: #606266; font-size: 14px;">{{ $message->offer_description }}</p>
                        <div class="mx-3 d-lg-flex d-md-flex col-12">
                            <div class="col-4">
                                <p class="font-expiry-delivery">Delivery Date</p>
                                <p class="mx-1"
                                   style="color: #606266; font-size: 14px;"> @if($message->offer_delivery)
                                        {{ $message->offer_delivery }}
                                    @else
                                        ---
                                    @endif</p>
                            </div>
                            <div class="col-8">
                                <p class="font-expiry-delivery">Expiry Date</p>
                                <p style="color: #606266; font-size: 14px;">{{ $message->offer_expiry }}</p>
                            </div>
                        </div>
                        <div class="d-none d-flex mb-2 px-3 offer-accepted"
                             id="offer-accepted-{{$message->id}}">
                            <button type="button"
                                    class="rounded my-2 py-2 w-100 pending-button-1"
                                    style="border: 1px solid #DCDFE6; font-size: 16px;">
                                Offer Accepted
                            </button>
                        </div>
                        <div class="d-none d-flex mb-2 px-3 offer-rejected"
                             id="offer-rejected-{{$message->id}}">
                            <button type="button"
                                    class="rounded my-2 py-2 w-100 pending-button-1"
                                    style="border: 1px solid #DCDFE6; font-size: 16px;">
                                Offer Rejected
                            </button>
                        </div>
                        @if ($message->user_id !== auth()->id())
                            @if ($message->is_offer === null && $message->is_withdrawn == 0 &&!$message->closed)
                                <!-- Show Accept/Reject buttons only if the current user is not the message owner and the message is not withdrawn and has no offer -->
                                <div class="d-flex mb-2 mx-2 acceptedRejected">
                                    @if($message->is_counter)
                                        <button
                                            class="rounded py-2 w-100 pending pending-button-1 pending-button-text"
                                            id="pending-{{$message->id}}">
                                            Offer Countered
                                        </button>
                                    @else
                                        @if((!($message->message_ad_id!=$ad->id)&&$messageUser->user->hasRole('user')&&$message->ad->user_id==auth()->id())||auth()->user()->is_premium)
                                            <button type="button"
                                                    class="btn bg-light mx-2 accept-offer"
                                                    id="accept-offer-{{ $message->id }}"
                                                    data-offer-id="{{ $message->offer_id }}"
                                                    style="border: 1px solid #DCDFE6">
                                                Accept
                                            </button>
                                            <button type="button"
                                                    class="btn text-white bg-pink reject-offer"
                                                    id="reject-offer-{{$message->id }}"
                                                    data-offer-id="{{ $message->offer_id }}"
                                                    data-id="{{ $message->id }}">
                                                Reject
                                            </button>
                                            <div class="ms-auto">
                                                @php
                                                    $isMessageInMatchingMessages=null;
                                                       $messageCardAd = Ad::find($message->counted_ad_id);
                                                       if (is_null($messageCardAd)) {
                                                           $messageCardAd = Ad::find($message->ad_id);
                                                       }

                                                       if($matchingMessages !=null){
                                                               $isMessageInMatchingMessages = $matchingMessages ? $matchingMessages->contains('id', $message->id) : null;
                                                       }
                                                @endphp
                                                @if ($messageUser->user->hasRole('user'))
                                                    <button
                                                        class="text-white px-2 card-price bg-pink rounded py-2 border-0 respond counter-offer"
                                                        id="counterOffer-{{ $messageCardAd->id }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#counterModal"
                                                        data-ad-image="{{ $message->ad_image }}"
                                                        data-prev-offer-id="{{ $message->offer_id }}"
                                                        data-offer-delivery="{{ $message->offer_delivery ?? null }}"
                                                        data-offer-expiry="{{ $message->offer_expiry ?? null }}"
                                                        data-offer-description="{{ $message->offer_description ?? null }}"
                                                        data-ad-title="{{ $message->offer_title }}"
                                                        data-ad-price="{{ $message->ad_price }}"
                                                        data-ad-id="{{ $message->ad_id }}"
                                                        data-msg-ad-id="{{ $messageCardAd->id }}"
                                                        data-ad-car-name="{{ $messageCardAd->car_name }}"
                                                        data-ad-primary-avatar="{{ $messageCardAd->primary_avatar }}"
                                                        data-ad-mileage="{{ $message->ad_mileage . $message->ad_mileage_type }}"
                                                        data-ad-year="{{ $message->ad_year }}"
                                                        data-ad-make="{{ $messageCardAd->make }}"
                                                        data-ad-model="{{ $messageCardAd->model }}"
                                                        data-receiver-id="{{ $message->user_id }}"
                                                        data-source="counter_offer">
                                                        Counter Offer
                                                    </button>
                                                @endif
                                            </div>
                                        @else
                                            <a href="{{route('dealer.subscription_plan')}}"
                                               class="btn bg-light mx-2 accept-offer "
                                               style="border: 1px solid #DCDFE6"
                                               title="Upgrade to a Premium Plan to continue managing deals.">Accept</a>
                                            <a href="{{route('dealer.subscription_plan')}}"
                                               class="btn text-white bg-pink reject-offer"
                                               title="Upgrade to a Premium Plan to continue managing deals.">Reject</a>
                                            @if($chatuser->hasRole('user'))
                                                <div class="ms-auto">
                                                    <a href="{{route('dealer.subscription_plan')}}"
                                                       class="text-white btn px-2 card-price bg-pink rounded py-2 border-0 respond counter-offer"
                                                       title="Upgrade to a Premium Plan to continue managing deals.">Counter
                                                        Offer</a>
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            @elseif ($message->closed)
                                <div class="d-flex mb-2 px-3 offer-rejected">
                                    <button type="button"
                                            class="rounded my-2 py-2 w-100 pending-button-1"
                                            style="border: 1px solid #DCDFE6; font-size: 16px; ">
                                        Offer Closed
                                    </button>
                                </div>
                            @elseif ($message->is_withdrawn == 0 && $message->offer_id && $message->is_offer === 0)
                                <!-- Show Offer Rejected button only if the message has an offer but is not accepted and not withdrawn -->
                                <div class="d-flex mb-2 px-3 offer-rejected">
                                    <button type="button"
                                            class="rounded my-2 py-2 w-100 pending-button-1"
                                            style="border: 1px solid #DCDFE6; font-size: 16px; ">
                                        Offer Rejected
                                    </button>
                                </div>
                            @elseif ($message->is_withdrawn == 0 && $message->offer_id && $message->is_offer === 1)
                                <!-- Show Offer Accepted button only if the message has an offer and is accepted and not withdrawn -->
                                <div class="d-flex mb-2 px-3 offer-accepted"
                                     id="offer-accepted-{{$message->id}}">
                                    <button type="button"
                                            class="rounded my-2 py-2 w-100 pending-button-1"
                                            style="border: 1px solid #DCDFE6; font-size: 16px;">
                                        Offer Accepted
                                    </button>
                                </div>
                            @elseif ($message->is_withdrawn == 1 && $message->offer_id)
                                <!-- Show Withdrawn button only if the message is withdrawn and has an offer -->
                                <div class="d-flex mb-4 acceptedRejected px-2">
                                    <button type="button"
                                            class="btn bg-light mx-2 w-100 disabled withdrawn-12"
                                            style="border: 1px solid #DCDFE6; background: red !important; color: white">
                                        Withdrawn
                                    </button>
                                </div>
                            @endif
                        @endif
                        @if ($message->user_id == auth()->id())
                            <div class="">
                                @if ($message->offer_id && $message->is_offer === NULL && $message->is_withdrawn == 0)
                                    <!-- Show Pending button if the message is not withdrawn and has no offer -->
                                    @if($message->is_counter)
                                        <div class="d-flex mb-2 px-3">
                                            <button
                                                class="rounded py-2 w-100 mb-4 pending pending-button-1 pending-button-text"
                                                id="pending-{{$message->id}}">
                                                Offer Countered
                                            </button>
                                        </div>
                                    @elseif($message->closed)
                                        <div class="d-flex mb-2 px-3">
                                            <button
                                                class="rounded py-2 w-100 mb-4 pending pending-button-1 pending-button-text"
                                                id="pending-{{$message->id}}">
                                                Offer Closed
                                            </button>
                                        </div>
                                    @else
                                        <div class="d-flex mb-2 px-3">
                                            <button
                                                class="rounded py-2 w-100 pending pending-button-1 pending-button-text"
                                                id="pending-{{$message->id}}">
                                                Pending
                                            </button>
                                        </div>
                                        <div class="d-flex mb-2 px-3">
                                            <button
                                                class="rounded my-2 py-2 w-100 withdraw withdraw-offer x-sty-1 pending-button-1 withdraw-sty-1"
                                                id="witraw-{{$message->id}}"
                                                data-id="{{ $message->id }}"
                                                style="background: red; color: white">
                                                Withdraw
                                            </button>
                                        </div>
                                    @endif
                                @endif
                                @if ($message->offer_id && !$message->is_offer == 0 && $message->is_withdrawn == 0)
                                    <!-- Show Offer Accepted button only if the message has an offer and is accepted and not withdrawn -->
                                    <div
                                        class="d-flex mb-2 px-3 offer-accepted"
                                        id="pending-{{$message->id}}">
                                        <button type="button"
                                                class="rounded my-2 py-2 w-100 pending-button-1"
                                                style="border: 1px solid #DCDFE6; font-size: 16px;">
                                            Offer Accepted
                                        </button>
                                    </div>
                                @elseif ($message->offer_id && $message->is_offer === 0)
                                    <!-- Show Offer Rejected button only if the message has an offer but is not accepted and not withdrawn -->
                                    <div
                                        class="d-flex mb-4 px-3 offer-rejected">
                                        <button type="button"
                                                class="rounded my-2 py-2 w-100 pending-button-1"
                                                style="border: 1px solid #DCDFE6">
                                            Offer Rejected
                                        </button>
                                    </div>
                                @elseif ($message->is_withdrawn === 1)
                                    <!-- Show Withdrawn button only if the message is withdrawn and has an offer -->
                                    <div
                                        class="d-flex mb-4 acceptedRejected px-2">
                                        <button type="button"
                                                class="btn bg-light mx-2 w-100 disabled withdrawn-12"
                                                style="border: 1px solid #DCDFE6; background: red !important; color: white">
                                            Withdrawn
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            @endif
        @endif

        <!--end::Message(in)-->

    @endforeach
    <!--begin::Message(out)-->
@endforeach
