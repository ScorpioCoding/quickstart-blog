window.showPosts = (lang, slug) => {
  console.log(lang, slug);
  window.location = "/" + lang + "/posts/slug/" + slug;
};
