<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerXbBnXy0\srcApp_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerXbBnXy0/srcApp_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerXbBnXy0.legacy');

    return;
}

if (!\class_exists(srcApp_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerXbBnXy0\srcApp_KernelDevDebugContainer::class, srcApp_KernelDevDebugContainer::class, false);
}

return new \ContainerXbBnXy0\srcApp_KernelDevDebugContainer([
    'container.build_hash' => 'XbBnXy0',
    'container.build_id' => 'ddc5ea81',
    'container.build_time' => 1577649782,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerXbBnXy0');
