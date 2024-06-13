async function getCached(url) {
  if (!("caches" in window)) {
    return fetch(url);
  }

  const cacheName = "bo-cache";
  let cachedData = await getCachedData(cacheName, url);

  if (cachedData) {
    return cachedData;
  }

  const cacheStorage = await caches.open(cacheName);
  await cacheStorage.add(url);
  cachedData = await getCachedData(cacheName, url);
  await deleteOldCaches(cacheName);

  return cachedData;
}

// Get data from the cache.
async function getCachedData(cacheName, url) {
  const cacheStorage = await caches.open(cacheName);
  const cachedResponse = await cacheStorage.match(url);

  if (!cachedResponse || !cachedResponse.ok) {
    return false;
  }

  return cachedResponse;
}

// Delete any old caches to respect user's disk space.
async function deleteOldCaches(currentCache) {
  const keys = await caches.keys();

  for (const key of keys) {
    const isOurCache = "myapp-" === key.substr(0, 6);

    if (currentCache === key || !isOurCache) {
      continue;
    }

    caches.delete(key);
  }
}

export default getCached;
