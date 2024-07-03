export default {
  base_url: location.origin,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    Accept: 'application/json',
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document
      .querySelector('meta[name="csrf-token"]')
      .getAttribute('content'),
    // Authorization: 'Bearer ' + localStorage.getItem("user-token"),
  },

  getPath(url) {
    if (/^(https?:\/\/|:\/\/)/.test(url)) {
      return url
    }
    return this.base_url + '/' + url.replace(/^\//, '')
  },

  fetchArgs(...args) {
    return fetch(...args).then(async (response) => {
      const contentType = response.headers.get('content-type')
      if (response.ok) {
        return response
      }
      if (contentType && contentType.indexOf('application/json') !== -1) {
        const json = await response.json()

        if (json.errors || json.message) {
          const error = json.errors
            ? Object.values(json.errors).flat().join('\n')
            : json.message
          throw new Error(error)
        }
      }
      throw new Error('Something went wrong')
    })
  },

  get(url, raw = false) {
    return this.fetchArgs(this.getPath(url), {
      headers: this.getHeaders(),
    }).then((response) => this.getResponse(response, raw))
  },

  post(url, data, raw = false) {
    return this.fetchArgs(this.getPath(url), {
      method: 'POST',
      headers: this.getHeaders(),
      body: JSON.stringify(data),
    }).then((response) => this.getResponse(response, raw))
  },

  postFile(url, data) {
    let headers = Object.assign({}, this.getHeaders())

    delete headers['Content-Type']

    if (data.constructor.name != 'FormData') {
      let fd = new FormData()

      for (let prop in data) fd.append(prop, data[prop])

      data = fd
    }

    return this.fetchArgs(this.getPath(url), {
      method: 'POST',
      headers: headers,
      body: data,
    }).then((response) => this.getResponse(response))
  },

  put(url, data) {
    return this.fetchArgs(this.getPath(url), {
      method: 'PUT',
      headers: this.getHeaders(),
      body: JSON.stringify(data),
    }).then((response) => this.getResponse(response, true))
  },

  getResponse(response, raw = false) {
    return raw ? response.text() : response.json()
  },

  getHeaders(raw = false) {
    return this.headers
  },

  setToken() {
    this.headers.Authorization = 'Bearer ' + localStorage.getItem('user-token')
  },

  setSocketId(socketId) {
    this.headers['X-Socket-ID'] = socketId
  },
}
