<template>
  <div class="h-screen md:flex">
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center">
      <h1 class="text-6xl">SpaceChat</h1>
      <p class="text-lg">Chat with your friends, find new friends</p>
    </div>
    <div class="w-full md:w-1/2 flex justify-center items-center">
      <router-view />
    </div>
  </div>
</template>
