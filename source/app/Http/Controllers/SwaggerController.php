<?php

declare(strict_types=1);

namespace App\Http\Controllers;

/** @codeCoverageIgnore */
class SwaggerController extends Controller
{
    /**
     * @OA\Info(
     *      version="v1",
     *      title="Lendflow Assessment API",
     *      description="This is the API documentation for the New York Times Best Sellers wrapper.
## Versioning and Support Strategy
- **v1**: Current stable version. Fully supported until March 2, 2026. This version provides access to the NYT Best Sellers history and is guaranteed to remain unchanged until the support period ends.
- **v2**: Planned release in June 2025. This version may introduce new features and breaking changes. Users are encouraged to migrate to v2 within 6 months of its release to ensure continued support and access to the latest enhancements.
- **Breaking Changes**: Significant updates that affect compatibility will only be introduced in new major versions (e.g., v2, v3). Deprecated endpoints or parameters will be marked as such and supported for at least 6 months after a new version is released, giving users time to transition.
- **Support Policy**: Each major version is supported for a minimum of 1 year after the release of the subsequent version. Critical security fixes may be provided beyond this period if necessary.
- **Notifications**: Users will be informed of upcoming changes or deprecations via HTTP headers (e.g., 'Warning') and updates to this documentation.

For detailed change logs, refer to the [CHANGELOG.md](https://github.com/Lapinskas/test-laravel/blob/main/CHANGELOG.md) file in the repository.",
     *
     *      @OA\Contact(
     *          email="vlad.lapinskas@gmail.com"
     *      ),
     *
     *      @OA\Tag(
     *          name="Stable",
     *          description="Fully supported, no changes planned"
     *      ),
     *      @OA\Tag(
     *          name="Deprecated",
     *          description="Will be removed at next major release"
     *      ),
     *      @OA\Tag(
     *          name="Experimental",
     *          description="Subject to change without notice"
     *      )
     * )
     */
    public function dummy(): void {} // required by Swagger
}
