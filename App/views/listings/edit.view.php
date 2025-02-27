<?php
loadPartial('head');
loadPartial('navbar');
loadPartial('top-banner');

?>

<!-- Post a Job Form Box -->
<section class="flex justify-center items-center mt-20">
  <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
    <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>
    <?php loadPartial('errors', [
      'errors' => $errors ?? [],
    ]) ?>
    <form method="POST" action="/listings/<?= $fields->id ?>">
      <input type="hidden" name="_method" value="PUT">
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Job Info
      </h2>
      <div class="mb-4">
        <input
          type="text"
          name="title"
          value="<?= $fields->title ?? '' ?>"
          placeholder="Job Title"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <textarea
          name="description"
          placeholder="Job Description"
          class="w-full px-4 py-2 border rounded focus:outline-none"><?= $fields->description ?? '' ?></textarea>
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="salary"
          value="<?= $fields->salary ?? '' ?>"
          placeholder="Annual Salary"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="requirements"
          value="<?= $fields->requirements ?? '' ?>"
          placeholder="Requirements"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="benefits"
          value="<?= $fields->benefits ?? '' ?>"
          placeholder="Benefits"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="tags"
          value="<?= $fields->tags ?? '' ?>"
          placeholder="Tags"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
        Company Info & Location
      </h2>
      <div class="mb-4">
        <input
          type="text"
          name="company"
          value="<?= $fields->company ?? '' ?>"
          placeholder="Company Name"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="address"
          value="<?= $fields->address ?? '' ?>"
          placeholder="Address"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="city"
          value="<?= $fields->city ?? '' ?>"
          placeholder="City"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="state"
          value="<?= $fields->state ?? '' ?>"
          placeholder="State"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="text"
          name="phone"
          value="<?= $fields->phone ?? '' ?>"
          placeholder="Phone"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <div class="mb-4">
        <input
          type="email"
          name="email"
          value="<?= $fields->email ?? '' ?>"
          placeholder="Email Address For Applications"
          class="w-full px-4 py-2 border rounded focus:outline-none" />
      </div>
      <button
        class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
        Save
      </button>
      <a
        href="/listings/<?= $fields->id ?? '' ?>"
        class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
        Cancel
      </a>
    </form>
  </div>
</section>

<?php
loadPartial('bottom-banner');
loadPartial('footer');

?>