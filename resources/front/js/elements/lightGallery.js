import lightGallery from 'lightgallery'

import lgThumbnail from 'lightgallery/plugins/thumbnail'
import lgZoom from 'lightgallery/plugins/zoom'
// import lgHash from 'lightgallery/plugins/hash'
import lgVideo from 'lightgallery/plugins/video'

import 'lightgallery/css/lightgallery-bundle.css'
import 'lightgallery/css/lg-thumbnail.css'
import 'lightgallery/css/lg-zoom.css'
import 'lightgallery/css/lg-video.css'

document.querySelectorAll('.lightgallery').forEach((el) => {
  lightGallery(el, {
    plugins: [lgThumbnail, lgZoom, lgVideo],
    counter: false,
    download: false,
    thumbnail: true,
    zoom: true,
    preload: 0,
    scale: 1.5,
    thumbWidth: 70,
  })
})
