<template>
    <div class="container">
      <Toast />
      <div class="card">
        <div class="card-header">
          <div class="card-title">
            <div class="p-input-icon-left">
              <i class="pi pi-search" />
              <InputText
                v-model="searchQuery"
                placeholder="Rechercher un utilisateur"
                class="w-full md:w-auto"
              />
            </div>
          </div>
          <div class="card-toolbar">
            <Button
              label="Importer"
              icon="pi pi-upload"
              class="p-button-success mr-2"
              @click="openImportModal"
            />
            <Button
              label="Ajouter un utilisateur"
              icon="pi pi-plus"
              class="p-button-primary"
              @click="openModal"
            />
          </div>
        </div>
        <div class="card-body">
          <DataTable
            v-model:selection="selectedUsers"
            :value="filteredUsers"
            dataKey="id"
            :paginator="true"
            :rows="10"
            paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
            :rowsPerPageOptions="[5, 10, 25, 50]"
            currentPageReportTemplate="Affichage de {first} à {last} sur {totalRecords} utilisateurs"
            :loading="isLoading"
            :globalFilterFields="['name', 'email', 'roles']"
            responsiveLayout="scroll"
          >
            <Column selectionMode="multiple" headerStyle="width: 3rem" />
            <Column field="name" header="Utilisateur" sortable>
              <template #body="slotProps">
                <div class="flex align-items-center">
                  <Avatar
                    :image="slotProps.data.avatar"
                    v-if="slotProps.data.avatar"
                    class="mr-2"
                    shape="circle"
                    size="large"
                  />
                  <Avatar
                    v-else
                    :label="slotProps.data.name ? slotProps.data.name[0] : ''"
                    class="mr-2"
                    shape="circle"
                    size="large"
                  />
                  <div>
                    <div class="font-bold">{{ slotProps.data.name }} {{ slotProps.data.post_name }}</div>
                    <div class="text-sm">{{ slotProps.data.email }}</div>
                  </div>
                </div>
              </template>
            </Column>
            <Column field="roles" header="Rôle" sortable>
              <template #body="slotProps">
                <div class="flex flex-wrap gap-2">
                  <Tag
                    v-for="role in slotProps.data.roles"
                    :key="role"
                    severity="success"
                    rounded
                    :value="role"
                  />
                </div>
              </template>
            </Column>
            <Column field="last_connection" header="Connexion" sortable>
              <template #body="slotProps">
                <div v-if="slotProps.data.id !== authUserId">
                  <Tag
                    :value="slotProps.data.last_connection ? slotProps.data.last_connection : 'Aucune connection'"
                    severity="info"
                    rounded
                  />
                </div>
                <div v-else>
                  <Tag value="Connecté" severity="success" rounded />
                </div>
              </template>
            </Column>
            <Column field="phone" header="Téléphone" sortable />
            <Column headerStyle="min-width: 10rem">
              <template #body="slotProps">
                <div class="flex justify-content-center gap-2">
                  <Button
                    icon="pi pi-pencil"
                    class="p-button-rounded p-button-text p-button-plain"
                    @click="editUser(slotProps.data)"
                  />
                  <Button
                    icon="pi pi-trash"
                    class="p-button-rounded p-button-text p-button-plain"
                    @click="confirmDeleteUser(slotProps.data)"
                  />
                </div>
              </template>
            </Column>
          </DataTable>
        </div>
      </div>

      <Dialog
        v-model:visible="modalVisible"
        :header="modalHeader"
        :style="{ width: '50vw' }"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        modal
        class="p-fluid"
      >
        <form @submit.prevent="submitForm">
          <div class="field">
            <label for="name">Nom</label>
            <InputText id="name" v-model="formData.name" type="text" required />
          </div>
          <div class="field">
            <label for="post_name">Prénom</label>
            <InputText id="post_name" v-model="formData.post_name" type="text" required />
          </div>
          <div class="field">
            <label for="phone">Téléphone</label>
            <InputText id="phone" v-model="formData.phone" type="tel" required />
          </div>
          <div class="field">
            <label for="email">Email</label>
            <InputText id="email" v-model="formData.email" type="email" required />
          </div>
          <div class="field">
            <label for="password">Mot de passe</label>
            <InputText id="password" v-model="formData.password" type="password" required />
          </div>
          <div class="field">
            <label for="role">Rôle</label>
            <Dropdown
              id="role"
              v-model="formData.role"
              :options="roles"
              optionLabel="name"
              placeholder="Sélectionner un rôle"
              required
            />
          </div>
          <div class="field">
            <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
            <div
              class="image-input image-input-outline"
              data-kt-image-input="true"
              style="background-image: url(assets/media/avatars/blank.png)"
            >
              <div
                class="image-input-wrapper w-125px h-125px"
                :style="{
                  backgroundImage: `url(${
                    formData.avatarPreview || 'assets/media/avatars/connectors.jpeg'
                  })`,
                }"
              ></div>
              <label
                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="change"
                data-bs-toggle="tooltip"
                title="Change avatar"
              >
                <i class="pi pi-pencil fs-7"></i>
                <input
                  type="file"
                  name="avatar"
                  accept=".png, .jpg, .jpeg"
                  @change="handleAvatarChange"
                />
                <input type="hidden" name="avatar_remove" />
              </label>
              <span
                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="cancel"
                data-bs-toggle="tooltip"
                title="Cancel avatar"
              >
                <i class="pi pi-times fs-2"></i>
              </span>
              <span
                class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                data-kt-image-input-action="remove"
                data-bs-toggle="tooltip"
                title="Remove avatar"
              >
                <i class="pi pi-times fs-2"></i>
              </span>
            </div>
            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
          </div>
          <div class="flex justify-content-end gap-2 mt-4">
            <Button label="Annuler" class="p-button-secondary" @click="closeModal" />
            <Button label="Envoyer" type="submit" class="p-button-primary" />
          </div>
        </form>
      </Dialog>

      <Dialog
        v-model:visible="importModalVisible"
        header="Importer des utilisateurs"
        :style="{ width: '50vw' }"
        :breakpoints="{ '960px': '75vw', '640px': '100vw' }"
        modal
      >
        <div class="field">
          <label for="file">Fichier</label>
          <input type="file" ref="fileInput" @change="handleFileChange" accept=".xlsx, .xls" />
        </div>
        <div class="flex justify-content-end gap-2 mt-4">
          <Button label="Annuler" class="p-button-secondary" @click="closeImportModal" />
          <Button
            label="Importer"
            class="p-button-primary"
            :disabled="!selectedFile"
            @click="importUsers"
          />
        </div>
      </Dialog>

      <ConfirmDialog />
    </div>
  </template>

