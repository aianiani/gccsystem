<?php if($paginator->hasPages()): ?>
    <nav class="d-flex justify-content-center my-3">
        <ul class="pagination pagination-modern mb-0" style="gap: 0.25rem;">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled">
                    <span class="page-link rounded-circle border-0 bg-light text-secondary" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&lsaquo;</span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a class="page-link rounded-circle border-0 bg-white text-primary" href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&lsaquo;</a>
                </li>
            <?php endif; ?>

            
            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if(is_string($element)): ?>
                    <li class="page-item disabled"><span class="page-link border-0 bg-transparent text-secondary"><?php echo e($element); ?></span></li>
                <?php endif; ?>

                
                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <li class="page-item active">
                                <span class="page-link rounded-circle border-0 bg-primary text-white fw-bold" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;"><?php echo e($page); ?></span>
                            </li>
                        <?php else: ?>
                            <li class="page-item">
                                <a class="page-link rounded-circle border-0 bg-white text-primary" href="<?php echo e($url); ?>" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;"><?php echo e($page); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a class="page-link rounded-circle border-0 bg-white text-primary" href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&rsaquo;</a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link rounded-circle border-0 bg-light text-secondary" style="width:2.2rem; height:2.2rem; display:flex; align-items:center; justify-content:center; font-size:1.1rem;">&rsaquo;</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/vendor/pagination/bootstrap-5.blade.php ENDPATH**/ ?>