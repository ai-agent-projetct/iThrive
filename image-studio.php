<?php
/**
 * Image Studio — Visual Management & Google Flow Drop Hub for 80+ Bespoke 3D Assets.
 */

declare(strict_types=1);

require_once __DIR__ . '/includes/config.php';

$manifestFile = __DIR__ . '/storage/image_manifest.json';
$manifest = file_exists($manifestFile) ? json_decode(file_get_contents($manifestFile), true) : [];

// Handle AJAX image upload per slot
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'upload') {
    header('Content-Type: application/json');
    $slotId = $_POST['slot_id'] ?? '';
    
    $targetItem = null;
    foreach ($manifest as $item) {
        if ($item['id'] === $slotId) {
            $targetItem = $item;
            break;
        }
    }
    
    if (!$targetItem || empty($_FILES['image']['tmp_name'])) {
        echo json_encode(['error' => 'Invalid slot or missing file']);
        exit;
    }
    
    $destRel = $targetItem['dest'];
    $destPath = ROOT_PATH . '/' . $destRel;
    
    $dir = dirname($destPath);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    
    if (move_uploaded_file($_FILES['image']['tmp_name'], $destPath)) {
        echo json_encode([
            'success' => true,
            'slot_id' => $slotId,
            'url' => asset($destRel)
        ]);
    } else {
        echo json_encode(['error' => 'Failed to save uploaded image']);
    }
    exit;
}

// Group slots by page
$pages = [];
foreach ($manifest as $item) {
    $p = $item['page'];
    if (!isset($pages[$p])) {
        $pages[$p] = [];
    }
    $pages[$p][] = $item;
}

$pageTitles = [
    'cloud-devops' => 'Cloud & DevOps Services',
    'micro-saas' => 'Micro SaaS Development',
    'custom-product' => 'Custom Product Development',
    'product-modernization' => 'Product Modernization',
    'ai-native' => 'AI-Native Product Development',
    'ai-enablement' => 'AI Enablement for Existing Products',
];

$page = 'tools';
$pageTitle = 'iThrive 3D Image Studio';
// An internal upload tool: useful to us, worthless in a search result.
$robots    = 'noindex, nofollow';
require __DIR__ . '/includes/header.php';
?>

<div class="shell" style="padding-top: 100px; padding-bottom: 80px;">
  <div style="margin-bottom: 40px; border-bottom: 1px solid rgba(0, 242, 254, 0.2); padding-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
      <div>
        <p style="color: var(--cyan); font-family: var(--font-mono); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 8px;">Studio Workspace</p>
        <h1 style="font-size: 2.4rem; color: #fff; margin: 0;">Bespoke 3D Image Hub</h1>
        <p style="color: var(--text-muted); margin-top: 8px; max-width: 680px;">
          Manage the 80+ section images across all 7 service pages. Copy tailored prompts directly to 
          <a href="https://flow.google" target="_blank" style="color: var(--cyan); text-decoration: underline;">Google Flow</a>, 
          and drop the generated assets onto any card below to instantly update the live site.
        </p>
      </div>
      <div style="display: flex; gap: 12px; align-items: center;">
        <span style="background: rgba(0, 242, 254, 0.1); border: 1px solid var(--cyan); color: var(--cyan); padding: 6px 14px; border-radius: 20px; font-family: var(--font-mono); font-size: 0.85rem;">
          <?= count($manifest) ?> Target Slots
        </span>
      </div>
    </div>
    
    <!-- Filter Tabs -->
    <div style="display: flex; gap: 10px; margin-top: 24px; overflow-x: auto; padding-bottom: 8px;">
      <button class="tab-btn active" onclick="filterPage('all', this)" style="background: #131B2A; border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 0.88rem;">All Pages</button>
      <?php foreach ($pages as $pKey => $items): ?>
        <button class="tab-btn" onclick="filterPage('<?= e($pKey) ?>', this)" style="background: #131B2A; border: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); padding: 8px 16px; border-radius: 8px; cursor: pointer; font-size: 0.88rem;">
          <?= e($pageTitles[$pKey] ?? $pKey) ?> (<?= count($items) ?>)
        </button>
      <?php endforeach; ?>
    </div>
  </div>

  <?php foreach ($pages as $pKey => $items): ?>
    <div class="page-group" data-page="<?= e($pKey) ?>" style="margin-bottom: 50px;">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="font-size: 1.4rem; color: #fff; display: flex; align-items: center; gap: 10px;">
          <span style="display: inline-block; width: 8px; height: 8px; background: var(--cyan); border-radius: 50%;"></span>
          <?= e($pageTitles[$pKey] ?? $pKey) ?>
        </h2>
        <a href="<?= e(url('services/' . ($pKey === 'micro-saas' ? 'micro-saas-development' : ($pKey === 'custom-product' ? 'custom-product-development' : $pKey)) . '.php')) ?>" target="_blank" style="color: var(--cyan); font-size: 0.85rem; font-family: var(--font-mono); text-decoration: none;">
          View Live Route &rarr;
        </a>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 24px;">
        <?php foreach ($items as $item): ?>
          <?php
          $destPath = ROOT_PATH . '/' . $item['dest'];
          $exists = is_file($destPath);
          $previewUrl = $exists ? asset($item['dest']) : '';
          ?>
          <div class="slot-card" id="card-<?= e($item['id']) ?>" style="background: #0E1420; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 12px; overflow: hidden; display: flex; flex-direction: column;">
            
            <!-- Image Area / Drop Target -->
            <div class="drop-zone" 
                 data-slot="<?= e($item['id']) ?>" 
                 ondragover="event.preventDefault(); this.style.borderColor='var(--cyan)';" 
                 ondragleave="this.style.borderColor='rgba(255,255,255,0.1)';" 
                 ondrop="handleDrop(event, '<?= e($item['id']) ?>')"
                 onclick="document.getElementById('input-<?= e($item['id']) ?>').click()"
                 style="height: 220px; background: #070A10; border-bottom: 1px solid rgba(255,255,255,0.08); position: relative; display: flex; align-items: center; justify-content: center; cursor: pointer; overflow: hidden;">
              
              <input type="file" id="input-<?= e($item['id']) ?>" style="display: none;" accept="image/*" onchange="handleFileSelect(event, '<?= e($item['id']) ?>')">
              
              <?php if ($exists): ?>
                <img class="preview-img" src="<?= e($previewUrl) ?>" alt="Preview" style="width: 100%; height: 100%; object-fit: cover;">
                <div style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; color: var(--cyan); font-family: var(--font-mono);">
                  <?= (int)$item['w'] ?> &times; <?= (int)$item['h'] ?>
                </div>
                <div class="hover-overlay" style="position: absolute; inset: 0; background: rgba(0, 242, 254, 0.2); opacity: 0; transition: opacity 0.2s; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
                  Click or Drop to Replace
                </div>
              <?php else: ?>
                <div style="text-align: center; padding: 20px;">
                  <p style="color: var(--cyan); font-size: 0.85rem; margin-bottom: 4px;">+ Drop Google Flow Render</p>
                  <p style="color: var(--text-muted); font-size: 0.75rem; margin: 0;"><?= (int)$item['w'] ?> &times; <?= (int)$item['h'] ?></p>
                </div>
              <?php endif; ?>
            </div>

            <!-- Content Area -->
            <div style="padding: 16px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
              <div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                  <h3 style="font-size: 1rem; color: #fff; margin: 0; font-weight: 600;"><?= e($item['title']) ?></h3>
                  <span style="font-family: var(--font-mono); font-size: 0.72rem; color: var(--text-muted);"><?= e(basename($item['dest'])) ?></span>
                </div>
                
                <!-- Prompt Box -->
                <div style="background: rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.06); border-radius: 6px; padding: 10px; margin-top: 10px; position: relative;">
                  <p id="prompt-<?= e($item['id']) ?>" style="color: #94a3b8; font-size: 0.78rem; line-height: 1.4; margin: 0; max-height: 64px; overflow-y: auto;">
                    <?= e($item['prompt']) ?>
                  </p>
                </div>
              </div>

              <div style="display: flex; justify-content: flex-end; margin-top: 14px;">
                <button type="button" onclick="copyPrompt('<?= e($item['id']) ?>', this)" style="background: rgba(0, 242, 254, 0.1); border: 1px solid var(--cyan); color: var(--cyan); padding: 6px 12px; border-radius: 6px; font-size: 0.78rem; cursor: pointer; font-family: var(--font-mono);">
                  Copy Prompt
                </button>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endforeach; ?>

</div>

<script>
function filterPage(pageKey, btn) {
  document.querySelectorAll('.tab-btn').forEach(b => b.style.color = 'var(--text-muted)');
  btn.style.color = '#fff';
  
  document.querySelectorAll('.page-group').forEach(group => {
    if (pageKey === 'all' || group.dataset.page === pageKey) {
      group.style.display = 'block';
    } else {
      group.style.display = 'none';
    }
  });
}

function copyPrompt(slotId, btn) {
  const text = document.getElementById('prompt-' + slotId).innerText;
  navigator.clipboard.writeText(text).then(() => {
    const orig = btn.innerText;
    btn.innerText = 'Copied!';
    btn.style.background = 'var(--cyan)';
    btn.style.color = '#000';
    setTimeout(() => {
      btn.innerText = orig;
      btn.style.background = 'rgba(0, 242, 254, 0.1)';
      btn.style.color = 'var(--cyan)';
    }, 2000);
  });
}

function handleDrop(e, slotId) {
  e.preventDefault();
  const dt = e.dataTransfer;
  const files = dt.files;
  if (files.length) {
    uploadFile(files[0], slotId);
  }
}

function handleFileSelect(e, slotId) {
  const files = e.target.files;
  if (files.length) {
    uploadFile(files[0], slotId);
  }
}

function uploadFile(file, slotId) {
  const card = document.getElementById('card-' + slotId);
  const dropZone = card.querySelector('.drop-zone');
  
  const formData = new FormData();
  formData.append('image', file);
  formData.append('slot_id', slotId);
  
  dropZone.style.opacity = '0.5';
  
  fetch('image-studio.php?action=upload', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    dropZone.style.opacity = '1';
    if (data.success) {
      let img = dropZone.querySelector('.preview-img');
      if (!img) {
        dropZone.innerHTML = '<img class="preview-img" style="width: 100%; height: 100%; object-fit: cover;">';
        img = dropZone.querySelector('.preview-img');
      }
      img.src = data.url + '?t=' + Date.now();
    } else {
      alert('Upload failed: ' + (data.error || 'Unknown error'));
    }
  })
  .catch(err => {
    dropZone.style.opacity = '1';
    alert('Upload error: ' + err);
  });
}
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
