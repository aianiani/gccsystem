<?php if($paginator->hasPages()): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm mb-0 gap-1" style="--bs-pagination-border-radius: 8px;">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 bg-transparent text-muted"><i class="bi bi-chevron-left"></i></span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link border-0 bg-light rounded-2 text-dark" href="<?php echo e($paginator->previousPageUrl()); ?>"
                        rel="prev"><i class="bi bi-chevron-left"></i></a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link border-0 bg-transparent text-muted"><?php echo e($element); ?></span>
                    </li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active" aria-current="page">
                                <span class="page-link border-0 rounded-2 px-3 fw-bold"
                                    style="background: var(--primary-green, #1f7a2d); color: #fff;"><?php echo e($page); ?></span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link border-0 bg-light rounded-2 text-dark px-3 fw-medium" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link border-0 bg-light rounded-2 text-dark" href="<?php echo e($paginator->nextPageUrl()); ?>"
                        rel="next"><i class="bi bi-chevron-right"></i></a>
                </li>
            <?php else: ?>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link border-0 bg-transparent text-muted"><i class="bi bi-chevron-right"></i></span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/vendor/pagination/premium-simple.blade.php ENDPATH**/ ?>