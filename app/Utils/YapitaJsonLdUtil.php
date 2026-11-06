<?php

namespace App\Utils;

use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class YapitaJsonLdUtil
{
    public const BUSINESS = 'BUSINESS';
    public const PRODUCT = 'PRODUCT';
    public const PROFILE = 'PROFILE';
    public const TASK = 'TASK';
    public const TASKS = 'TASKS';
    public const HOME = 'HOME';

    private const JSON_OPTIONS =
        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES |
        JSON_HEX_TAG |
        JSON_HEX_AMP |
        JSON_HEX_APOS |
        JSON_HEX_QUOT |
        JSON_THROW_ON_ERROR;

    private const DAYS = [
        'MONDAY' => 'Monday',
        'TUESDAY' => 'Tuesday',
        'WEDNESDAY' => 'Wednesday',
        'THURSDAY' => 'Thursday',
        'FRIDAY' => 'Friday',
        'SATURDAY' => 'Saturday',
        'SUNDAY' => 'Sunday',

        'LUNES' => 'Monday',
        'MARTES' => 'Tuesday',
        'MIERCOLES' => 'Wednesday',
        'MIÉRCOLES' => 'Wednesday',
        'JUEVES' => 'Thursday',
        'VIERNES' => 'Friday',
        'SABADO' => 'Saturday',
        'SÁBADO' => 'Saturday',
        'DOMINGO' => 'Sunday',
    ];

    /* ==========================================
       HOME - MEETCLIC / YAPITA
    ========================================== */

    private static function home(array $data): array
    {
        self::validate($data, [
            'url' => ['required', 'url', 'starts_with:https://'],
            'name' => ['required', 'string', 'max:255'],
            'organization.name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'organization.logo' => ['nullable', 'url'],
            'tasks' => ['sometimes', 'array'],
        ]);

        $url = rtrim($data['url'], '/');

        // 1. ORGANIZACIÓN CREADORA
        $organization = [
            '@type' => 'Organization',
            '@id' => $url . '/#organization',
            'name' => $data['organization']['name'],
            'url' => $url . '/',
        ];

        self::put(
            $organization,
            'description',
            self::clean(
                $data['organization']['description'] ?? null
            )
        );

        self::put(
            $organization,
            'logo',
            self::absoluteUrl(
                $data['organization']['logo'] ?? null
            )
        );

        self::put(
            $organization,
            'sameAs',
            self::urlList(
                $data['organization']['same_as'] ?? []
            )
        );

        if (!empty($data['organization']['contact'])) {
            $contact = $data['organization']['contact'];

            $contactPoint = [
                '@type' => 'ContactPoint',
                'contactType' => 'customer support',
            ];

            self::put(
                $contactPoint,
                'telephone',
                self::clean($contact['telephone'] ?? null)
            );

            self::put(
                $contactPoint,
                'email',
                filter_var(
                    $contact['email'] ?? null,
                    FILTER_VALIDATE_EMAIL
                ) ?: null
            );

            if (count($contactPoint) > 2) {
                $organization['contactPoint'] = $contactPoint;
            }
        }

        // 2. SITIO WEB
        $website = [
            '@type' => 'WebSite',
            '@id' => $url . '/#website',
            'url' => $url . '/',
            'name' => $data['name'],
            'publisher' => [
                '@id' => $url . '/#organization'
            ],
            'inLanguage' => $data['language'] ?? 'es',
        ];

        if (!empty($data['alternate_name'])) {
            $website['alternateName'] =
                $data['alternate_name'];
        }

        // 3. PÁGINA PRINCIPAL
        $page = [
            '@type' => [
                'WebPage',
                'CollectionPage'
            ],
            '@id' => $url . '/#webpage',
            'url' => $url . '/',
            'name' => $data['page_title'] ?? $data['name'],
            'description' => self::clean(
                $data['description'] ?? ''
            ),
            'isPartOf' => [
                '@id' => $url . '/#website'
            ],
            'about' => [
                '@id' => $url . '/#organization'
            ],
            'inLanguage' => $data['language'] ?? 'es',
        ];

        $graph = [
            $organization,
            $website,
            $page,
        ];

        // 4. LISTADO DE TAREAS PÚBLICAS
        $items = [];

        foreach (($data['tasks'] ?? []) as $task) {
            if (!is_array($task)) {
                continue;
            }

            $taskUrl = self::absoluteUrl(
                $task['url'] ?? null
            );

            $taskName = self::clean(
                $task['name'] ?? null
            );

            if (!$taskUrl || !$taskName) {
                continue;
            }

            $items[] = [
                '@type' => 'ListItem',
                'position' => count($items) + 1,
                'name' => $taskName,
                'url' => $taskUrl,
            ];
        }

        if (!empty($items)) {
            $listId = $url . '/#task-list';

            $graph[2]['mainEntity'] = [
                '@id' => $listId
            ];

            $graph[] = [
                '@type' => 'ItemList',
                '@id' => $listId,
                'name' => 'Tareas para ganar Yapitas',
                'numberOfItems' => count($items),
                'itemListElement' => $items,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@graph' => $graph,
        ];
    }

    /* ==========================================
       PUBLIC API
    ========================================== */

    public static function build(
        string $type,
        array  $data
    ): array
    {
        $type = strtoupper(trim($type));

        return match ($type) {
            self::BUSINESS => self::business($data),
            self::PRODUCT => self::product($data),
            self::PROFILE => self::profile($data),
            self::TASK => self::task($data),
            self::TASKS => self::tasks($data),
            self::HOME => self::home($data),

            default => throw new InvalidArgumentException(
                "Tipo JSON-LD no soportado: {$type}"
            ),
        };
    }

    public static function toJson(
        string $type,
        array  $data
    ): string
    {
        return self::encode(
            self::build($type, $data)
        );
    }

    public static function toScript(
        string $type,
        array  $data
    ): string
    {
        return '<script type="application/ld+json">' .
            self::toJson($type, $data) .
            '</script>';
    }

    public static function encode(array $schema): string
    {
        return json_encode(
            $schema,
            self::JSON_OPTIONS
        );
    }

    /* ==========================================
       VALIDATION
    ========================================== */

    private static function validate(
        array $data,
        array $rules
    ): void
    {
        Validator::make($data, $rules)->validate();
    }

    private static function commonRules(): array
    {
        return [
            'url' => ['required', 'url', 'starts_with:https://'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'url'],
        ];
    }

    /* ==========================================
       HELPERS
    ========================================== */

    private static function clean(
        mixed $value
    ): ?string
    {
        if (!is_scalar($value)) {
            return null;
        }

        $value = trim(strip_tags((string)$value));

        return $value === '' ? null : $value;
    }

    private static function put(
        array  &$schema,
        string $key,
        mixed  $value
    ): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (is_array($value) && empty($value)) {
            return;
        }

        $schema[$key] = $value;
    }

    private static function absoluteUrl(
        mixed $value
    ): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $url = trim($value);

        return filter_var($url, FILTER_VALIDATE_URL) &&
        in_array(
            strtolower(parse_url($url, PHP_URL_SCHEME) ?: ''),
            ['https'],
            true
        )
            ? $url
            : null;
    }

    private static function urlList(
        mixed $values
    ): array
    {
        if (!is_array($values)) {
            return [];
        }

        $result = [];

        foreach ($values as $value) {
            $url = self::absoluteUrl($value);

            if ($url) {
                $result[] = $url;
            }
        }

        return array_values(array_unique($result));
    }

    private static function base(
        string $type,
        string $url,
        string $suffix,
        string $name
    ): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => $type,
            '@id' => $url . '#' . $suffix,
            'url' => $url,
            'name' => self::clean($name),
        ];
    }

    private static function addCommon(
        array &$schema,
        array $data
    ): void
    {
        self::put(
            $schema,
            'description',
            self::clean($data['description'] ?? null)
        );

        self::put(
            $schema,
            'image',
            self::absoluteUrl($data['image'] ?? null)
        );

        $sameAs = self::urlList(
            $data['same_as'] ?? []
        );

        self::put($schema, 'sameAs', $sameAs);
    }

    /* ==========================================
       RATING
       Solamente valores reales/verificables
    ========================================== */

    private static function rating(
        mixed $data
    ): ?array
    {
        if (!is_array($data)) {
            return null;
        }

        $validator = Validator::make($data, [
            'value' => ['required', 'numeric', 'between:1,5'],
            'count' => ['required', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return null;
        }

        return [
            '@type' => 'AggregateRating',
            'ratingValue' => (float)$data['value'],
            'ratingCount' => (int)$data['count'],
            'bestRating' => 5,
            'worstRating' => 1,
        ];
    }

    private static function reviews(
        mixed $reviews
    ): array
    {
        if (!is_array($reviews)) {
            return [];
        }

        $result = [];

        foreach ($reviews as $review) {
            if (!is_array($review)) {
                continue;
            }

            $validator = Validator::make($review, [
                'author' => ['required', 'string'],
                'rating' => ['required', 'numeric', 'between:1,5'],
                'body' => ['required', 'string'],
                'date' => ['nullable', 'date'],
            ]);

            if ($validator->fails()) {
                continue;
            }

            $item = [
                '@type' => 'Review',
                'author' => [
                    '@type' => 'Person',
                    'name' => self::clean($review['author']),
                ],
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => (float)$review['rating'],
                    'bestRating' => 5,
                ],
                'reviewBody' => self::clean($review['body']),
            ];

            if (!empty($review['date'])) {
                $item['datePublished'] = date(
                    'Y-m-d',
                    strtotime($review['date'])
                );
            }

            $result[] = $item;
        }

        return $result;
    }

    /* ==========================================
       ADDRESS / LOCATION
    ========================================== */

    private static function address(
        mixed $data
    ): ?array
    {
        if (!is_array($data)) {
            return null;
        }

        $street = self::clean(
            $data['street'] ?? null
        );

        $city = self::clean(
            $data['city'] ?? null
        );

        $country = self::clean(
            $data['country'] ?? null
        );

        if (!$street || !$city || !$country) {
            return null;
        }

        $address = [
            '@type' => 'PostalAddress',
            'streetAddress' => $street,
            'addressLocality' => $city,
            'addressCountry' => $country,
        ];

        self::put(
            $address,
            'addressRegion',
            self::clean($data['region'] ?? null)
        );

        self::put(
            $address,
            'postalCode',
            self::clean($data['postal_code'] ?? null)
        );

        return $address;
    }

    private static function geo(
        mixed $data
    ): ?array
    {
        if (!is_array($data)) {
            return null;
        }

        $lat = $data['latitude'] ?? null;
        $lng = $data['longitude'] ?? null;

        if (!is_numeric($lat) || !is_numeric($lng)) {
            return null;
        }

        $lat = (float)$lat;
        $lng = (float)$lng;

        if (
            $lat < -90 || $lat > 90 ||
            $lng < -180 || $lng > 180 ||
            ($lat == 0 && $lng == 0)
        ) {
            return null;
        }

        return [
            '@type' => 'GeoCoordinates',
            'latitude' => $lat,
            'longitude' => $lng,
        ];
    }

    /* ==========================================
       OPENING HOURS
    ========================================== */

    private static function hours(
        mixed $rows
    ): array
    {
        if (!is_array($rows)) {
            return [];
        }

        $result = [];

        foreach ($rows as $row) {
            if (!is_array($row)) {
                continue;
            }

            $day = strtoupper(
                trim((string)($row['day'] ?? ''))
            );

            $day = self::DAYS[$day] ?? null;

            $opens = $row['opens'] ?? null;
            $closes = $row['closes'] ?? null;

            if (
                !$day ||
                !is_string($opens) ||
                !is_string($closes)
            ) {
                continue;
            }

            $pattern = '/^(?:[01]\d|2[0-3]):[0-5]\d(?::[0-5]\d)?$/';

            if (
                !preg_match($pattern, $opens) ||
                !preg_match($pattern, $closes)
            ) {
                continue;
            }

            $result[] = [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => 'https://schema.org/' . $day,
                'opens' => $opens,
                'closes' => $closes,
            ];
        }

        return $result;
    }

    /* ==========================================
       BUSINESS
    ========================================== */

    private static function business(
        array $data
    ): array
    {
        self::validate($data, array_merge(
            self::commonRules(),
            [
                'business_subcategories_id' => ['nullable', 'integer', 'between:1,76'],
                'business_type' => ['nullable', 'string'],
                'address' => ['nullable', 'array'],
                'address.street' => ['nullable', 'string'],
                'address.city' => ['nullable', 'string'],
                'address.country' => ['nullable', 'string'],
                'telephone' => ['nullable', 'string'],
                'email' => ['nullable', 'email'],
            ]
        ));

        // Resolver la clasificación desde el catálogo Yapita.
        // Si el negocio no tiene dirección pública verificable,
        // publicarlo como Organization (no como LocalBusiness).
        $address = self::address($data['address'] ?? null);
        $type = $address
            ? YapitaBusinessSchemaTypeUtil::resolve(
                isset($data['business_subcategories_id'])
                    ? (int) $data['business_subcategories_id']
                    : null,
                $data['business_type'] ?? null
            )
            : 'Organization';

        $schema = self::base(
            $type,
            $data['url'],
            'business',
            $data['name']
        );

        self::addCommon($schema, $data);

        self::put($schema, 'address', $address);

        self::put(
            $schema,
            'telephone',
            self::clean($data['telephone'] ?? null)
        );

        if (!empty($data['email']) &&
            filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $schema['email'] = $data['email'];
        }

        if ($type !== 'Organization') {
            self::put($schema, 'geo', self::geo($data['geo'] ?? null));
            self::put(
                $schema,
                'openingHoursSpecification',
                self::hours($data['hours'] ?? [])
            );
            self::put(
                $schema,
                'priceRange',
                self::clean($data['price_range'] ?? null)
            );
            self::put(
                $schema,
                'hasMap',
                self::absoluteUrl($data['map_url'] ?? null)
            );
        }

        // Para plataformas de reseñas independientes,
        // cuando corresponde y cumple las políticas.
        if ($type !== 'Organization' && !empty($data['include_rating'])) {
            self::put(
                $schema,
                'aggregateRating',
                self::rating($data['rating'] ?? null)
            );

            self::put(
                $schema,
                'review',
                self::reviews($data['reviews'] ?? [])
            );
        }

        return $schema;
    }

    /* ==========================================
       PRODUCT
    ========================================== */

    private static function product(
        array $data
    ): array
    {
        self::validate($data, array_merge(
            self::commonRules(),
            [
                'price' => ['required', 'numeric', 'min:0'],
                'currency' => [
                    'required',
                    'string',
                    'size:3',
                    'regex:/^[A-Z]{3}$/'
                ],
                'availability' => [
                    'nullable',
                    'in:InStock,OutOfStock,PreOrder,BackOrder,Discontinued,LimitedAvailability'
                ],
            ]
        ));

        $schema = self::base(
            'Product',
            $data['url'],
            'product',
            $data['name']
        );

        self::addCommon($schema, $data);

        self::put(
            $schema,
            'sku',
            self::clean($data['sku'] ?? null)
        );

        self::put(
            $schema,
            'brand',
            !empty($data['brand'])
                ? [
                '@type' => 'Brand',
                'name' => self::clean($data['brand'])
            ]
                : null
        );

        $offer = [
            '@type' => 'Offer',
            'url' => $data['url'],
            'price' => number_format(
                (float)$data['price'],
                2,
                '.',
                ''
            ),
            'priceCurrency' => $data['currency'],
        ];

        $availability = $data['availability'] ?? null;

        if ($availability) {
            $offer['availability'] =
                'https://schema.org/' . $availability;
        }

        if (!empty($data['seller']['name']) &&
            !empty($data['seller']['url'])) {

            $offer['seller'] = [
                '@type' => 'Organization',
                '@id' => $data['seller']['url'] . '#business',
                'name' => self::clean(
                    $data['seller']['name']
                ),
            ];
        }

        $schema['offers'] = $offer;

        self::put(
            $schema,
            'aggregateRating',
            self::rating($data['rating'] ?? null)
        );

        self::put(
            $schema,
            'review',
            self::reviews($data['reviews'] ?? [])
        );

        return $schema;
    }

    /* ==========================================
       PROFILE
    ========================================== */

    private static function profile(
        array $data
    ): array
    {
        self::validate($data, [
            'url' => ['required', 'url', 'starts_with:https://'],
            'name' => ['required', 'string', 'max:255'],
            'is_public' => ['required', 'accepted'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'url'],
        ]);

        $url = $data['url'];

        $person = [
            '@type' => 'Person',
            '@id' => $url . '#person',
            'name' => self::clean($data['name']),
            'url' => $url,
        ];

        self::addCommon($person, $data);

        self::put(
            $person,
            'alternateName',
            self::clean($data['username'] ?? null)
        );

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            '@id' => $url . '#webpage',
            'url' => $url,
            'mainEntity' => $person,
        ];

        self::put(
            $schema,
            'dateCreated',
            self::clean($data['created_at'] ?? null)
        );

        self::put(
            $schema,
            'dateModified',
            self::clean($data['updated_at'] ?? null)
        );

        return $schema;
    }

    /* ==========================================
       TASK - GAMIFICATION
    ========================================== */

    private static function task(
        array $data
    ): array
    {
        self::validate($data, self::commonRules());

        $url = $data['url'];

        // Schema.org genérico para describir
        // una actividad. No garantiza un rich result.
        $action = [
            '@type' => 'Action',
            '@id' => $url . '#action',
            'name' => self::clean($data['name']),
        ];

        self::put(
            $action,
            'description',
            self::clean($data['description'] ?? null)
        );

        self::put(
            $action,
            'target',
            self::absoluteUrl($data['action_url'] ?? null)
        );

        // Vincular actividad con la empresa.
        if (!empty($data['business_url'])) {
            $action['object'] = [
                '@type' => 'Organization',
                '@id' => $data['business_url'] . '#business',
            ];
        }

        $page = self::base(
            'WebPage',
            $url,
            'webpage',
            $data['name']
        );

        self::addCommon($page, $data);

        $page['mainEntity'] = $action;

        // Frecuencia y puntos se muestran en HTML.
        // No inventamos propiedades Schema.org
        // específicas para recompensas Yapitas.

        return $page;
    }

    /* ==========================================
       TASKS - PUBLIC TASK COLLECTION
    ========================================== */

    private static function tasks(
        array $data
    ): array
    {
        self::validate($data, self::commonRules());

        $url = $data['url'];

        $items = [];

        foreach (($data['items'] ?? []) as $item) {

            if (!is_array($item)) {
                continue;
            }

            $itemUrl = self::absoluteUrl(
                $item['url'] ?? null
            );

            $name = self::clean(
                $item['name'] ?? null
            );

            if (!$itemUrl || !$name) {
                continue;
            }

            $items[] = [
                '@type' => 'ListItem',
                'position' => count($items) + 1,
                'name' => $name,
                'url' => $itemUrl,
            ];
        }

        $schema = self::base(
            'CollectionPage',
            $url,
            'webpage',
            $data['name']
        );

        self::addCommon($schema, $data);

        $schema['mainEntity'] = [
            '@type' => 'ItemList',
            '@id' => $url . '#tasks',
            'numberOfItems' => count($items),
            'itemListElement' => $items,
        ];

        return $schema;
    }
}
