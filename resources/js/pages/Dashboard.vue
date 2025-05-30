<template>
    <div class="container mx-auto py-6">
      <div class="flex flex-col gap-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
          <h1 class="text-3xl font-bold">Auctions Dashboard</h1>
          <div class="flex items-center gap-4">
            <!-- Category Filter -->
            <Select v-model="selectedCategory" @update:modelValue="updateFilters">
              <SelectTrigger class="w-[200px]">
                <SelectValue placeholder="Select Category" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem :value="null">All Categories</SelectItem>
                <SelectItem v-for="category in categories" :key="category.id" :value="category.slug">
                  {{ category.name }}
                </SelectItem>
              </SelectContent>
            </Select>

            <!-- Status Filter -->
            <Select v-model="selectedStatus" @update:modelValue="updateFilters">
              <SelectTrigger class="w-[200px]">
                <SelectValue placeholder="Filter by Status" />
              </SelectTrigger>
              <SelectContent>
                <SelectItem :value="null">All Status</SelectItem>
                <SelectItem value="upcoming">Upcoming</SelectItem>
                <SelectItem value="active">Active</SelectItem>
                <SelectItem value="ended">Ended</SelectItem>
              </SelectContent>
            </Select>
          </div>
        </div>

        <!-- Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <Card v-for="item in items.data" :key="item.id" class="overflow-hidden">
            <CardHeader>
              <CardTitle>{{ item.name }}</CardTitle>
              <CardDescription>{{ item.category?.name }}</CardDescription>
            </CardHeader>
            <CardContent>
              <div class="space-y-2">
                <p class="text-sm text-muted-foreground line-clamp-2">{{ item.description }}</p>
                <div class="flex items-center justify-between">
                  <span class="font-semibold">Starting Price: ${{ item.starting_price }}</span>
                  <Badge :variant="getStatusVariant(item)">
                    {{ item.status }}
                  </Badge>
                </div>
                <div class="text-sm text-muted-foreground">
                  <p>Starts: {{ formatDate(item.start_at) }}</p>
                  <p>Ends: {{ formatDate(item.end_at) }}</p>
                </div>
              </div>
            </CardContent>
            <CardFooter>
              <Button class="w-full" disabled>
                View Details
              </Button>
            </CardFooter>
          </Card>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
          <Pagination
            v-slot="{ page }"
            :default-page="items.current_page"
            :items-per-page="items.per_page"
            :total="items.total"
            @update:page="handlePageChange"
          >
            <PaginationContent v-slot="{ items }">
              <PaginationPrevious @click="handlePageChange(items.current_page - 1)" />

              <template v-for="(item, index) in items" :key="index">
                <PaginationItem
                  v-if="item.type === 'page'"
                  :value="item.value"
                  :is-active="item.value === page"
                  @click="handlePageChange(item.value)"
                >
                  {{ item.value }}
                </PaginationItem>
                <PaginationEllipsis v-else-if="item.type === 'ellipsis'" :index="index" />
              </template>

              <PaginationNext @click="handlePageChange(items.current_page + 1)" />
            </PaginationContent>
          </Pagination>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'
  import { router } from '@inertiajs/vue3'
  import AppLayout from '@/layouts/AppLayout.vue'
  import { Card, CardHeader, CardTitle, CardDescription, CardContent, CardFooter } from '@/components/ui/card'
  import { Button } from '@/components/ui/button'
  import { Badge } from '@/components/ui/badge'
  import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
  import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious
  } from '@/components/ui/pagination'

  const props = defineProps({
    items: Object,
    categories: Array,
    currentCategory: String,
    currentStatus: String,
  })


  defineOptions({
      layout: AppLayout
  })

  const selectedCategory = ref(props.currentCategory || null)
  const selectedStatus = ref(props.currentStatus || null)

  const updateFilters = () => {
    router.get(
      route('dashboard'),
      {
        category: selectedCategory.value,
        status: selectedStatus.value,
      },
      {
        preserveState: true,
        preserveScroll: true,
        replace: true,
      }
    )
  }

  const handlePageChange = (page) => {
    router.get(
      route('dashboard'),
      {
        page,
        category: selectedCategory.value,
        status: selectedStatus.value,
      },
      {
        preserveState: true,
        preserveScroll: true,
      }
    )
  }

  const getStatusVariant = (item) => {
    switch (item.status) {
      case 'upcoming':
        return 'secondary'
      case 'active':
        return 'success'
      case 'ended':
        return 'destructive'
      default:
        return 'secondary'
    }
  }

  const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    })
  }
  </script>
