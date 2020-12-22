<?php
    if(isset($place->address))
        $schemaAddress = $place->address;
    else if(isset($place->dastresi))
        $schemaAddress = $place->dastresi;
    else
        $schemaAddress = false;

    $schemaPhone = false;
    if(isset($place->phone) && is_array($place->phone) && count($place->phone) > 0)
            $schemaPhone = true;
?>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    @if($kindPlaceId == 1)
        "@type": "LocalBusiness",
    @elseif($kindPlaceId == 3)
        "@type": "Restaurant",
    @elseif($kindPlaceId == 4)
        "@type": "Hotel",
        "starRating":"{{$place->rate}}",
{{--        "checkinTime":	"hh:mm:ss[Z|(+)03:30]",--}}
{{--        "checkoutTime":	"hh:mm:ss[Z|(+)03:30]",--}}
{{--        "numberOfRooms":"تعداد اتاق",--}}
    @elseif($kindPlaceId == 6)
        "@type": "LocalBusiness",
    @elseif($kindPlaceId == 10)
        "@type": "Product",
    @elseif($kindPlaceId == 11)
        "@type": "Recipe",
        "author": "koochita",
        "keywords": "{{$place->keyword}}",
        @if(isset($place->material))
        "recipeIngredient": [
            @foreach($place->material as $key => $mateial)
                "{{$mateial->name}}" {{$key == count($place->material)-1 ? '' : ','}}
            @endforeach
        ],
        @endif
        "nutrition":{
            "@type": "NutritionInformation",
            "calories": "{{$place->energy}} calories"
        },
        "recipeCategory" : "{{$place->kindName}}",
        "recipeCuisine" : "Persian food",
        "suitableForDiet" : [
            @if($place->vegetarian == 1)
                "https://schema.org/VegetarianDiet",
            @endif
            @if($place->vegan == 1)
                "https://schema.org/VeganDiet",
            @endif
            @if($place->diabet == 1)
                "https://schema.org/DiabeticDiet",
            @endif
            "https://schema.org/HalalDiet"
        ],
    @elseif($kindPlaceId == 12)
        "@type": "BedAndBreakfast",
    @endif

    "image": [
        {
            "@type": "ImageObject",
            "caption": "{{$place->keyword}}",
            "contentUrl": "{{$place->mainPic}}",
            "url": "{{$place->mainPic}}"
        }
    ],
    @if($schemaAddress != false)
    "address":[
        {
            "@type": "PostalAddress",
            "streetAddress": "{{$schemaAddress}}",
            "addressCountry": "IR",
            "addressRegion": "{{$city->name}}"
        }
    ],
    @endif

    @if(isset($place->firstReview) && $place->firstReview != null)
    "review":[
        {
            "@type": "Review",
            "itemReviewed":{
                "@type": "Thing",
                "name": "{{$place->firstReview->placeName}}",
                "image": "{{$place->firstReview->placeUrl}}"
            },
{{--            "reviewAspect": "مبدا و فصل",--}}
            "reviewBody": "{{$place->firstReview->text}}",
            "author":  {
                "@type": "Person",
                "additionalName": "{{$place->firstReview->userName}}",
                "image": "{{$place->firstReview->userPic}}"
            },
            "commentCount": "Integer ",
            "interactionStatistic": [
                {
                    "@type": "InteractionCounter",
                    "interactionType": "https://schema.org/LikeActin",
                    "userInteractionCount": "{{$place->firstReview->like}}"
                },
                {
                    "@type": "InteractionCounter",
                    "interactionType": "https://schema.org/DislikeActin",
                    "userInteractionCount": "{{$place->firstReview->disLike}}"
                }
            ],
            "dateCreated": "{{$place->firstReview->created_at}} +3:30",
            "sameAs": "{{$place->firstReview->placeUrl}}"
        }
    ],
    @endif

    @if(isset($place->firstQuestion) && $place->firstQuestion != null)
    "question":[
        {
            "@type":"Question",
            "about": "{{$place->firstQuestion->placeName}}",
            "abstract": "{{$place->firstQuestion->text}}",
            "answerCount": "{{$place->firstQuestion->answersCount}}",
            "author": {
                "@type": "Person",
                "additionalName": "{{$place->firstQuestion->userName}}",
                "image": "{{$place->firstQuestion->userPic}}"
            },
            @if(isset($place->firstQuestion->answers[0]))
            "acceptedAnswer": {
                "@type": "Answer",
                "abstract": "{{$place->firstQuestion->answers[0]->text}}",
                "author":  {
                    "@type": "Person",
                    "additionalName": "{{$place->firstQuestion->answers[0]->userName}}",
                    "image": "{{$place->firstQuestion->answers[0]->writerPic}}"
                }
            },
            @endif
        "dateCreated": "{{$place->firstQuestion->created_at}} +3:30"
{{--            "interactionStatistic": {--}}
{{--                "@type": "InteractionCounter",--}}
{{--                "interactionType": "https://schema.org/LikeActin",--}}
{{--                "userInteractionCount": "تعداد"--}}
{{--            },--}}
{{--            "interactionStatistic": {--}}
{{--                "@type": "InteractionCounter",--}}
{{--                "interactionType": "https://schema.org/DislikeActin",--}}
{{--                "userInteractionCount": "تعداد"--}}
{{--            },--}}
        }
    ],
    @endif

    @if($kindPlaceId != 11)
    "availableLanguage": [
        "en",
        "pr",
        "fr",
        "ar"
    ],
    @endif

    "aggregateRating":[
        {
            "ratingCount": "{{$total}}",
            "reviewCount": "{{$reviewCount == 0 ? 1 : $reviewCount}}",
            "bestRating": "5",
            "ratingValue": "{{$avgRate}}",
            "worstRating": "1"
        }
    ],
    "audience": [
        {
            "@type": "Audience",
            "audienceType": "tourist"
        }
    ],


    "description":"{{$place->meta}}",
    "name": "{{$place->name}}",
	"url": "{{Request::url()}}"
},
</script>