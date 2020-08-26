<template>
  <div class="flex flex-col justify-evenly h-screen md:flex-row bg-gradient-to-l">
    <div class="w-full md:w-1/2 flex flex-col justify-center items-center">
      <h1 class="text-6xl">SpaceChat</h1>
      <p class="text-lg text-center">Chat with your friends, find new friends</p>
    </div>
    <div class="w-full md:w-1/2 flex justify-center items-center">
      <router-view />
    </div>
  </div>
</template>
