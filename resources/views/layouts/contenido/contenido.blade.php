@extends('layouts.plantilla')

@section('contenido')

<template v-if="menu==0">
    <escritorio></escritorio>
</template>

<template v-if="menu==1">
    <almacen-categorias></almacen-categorias>
</template>

<template v-if="menu==2">
    <almacen-articulos></almacen-articulos>
</template>

<template v-if="menu==3">
    <compras-ingresos></compras-ingresos>
</template>

<template v-if="menu==4">
    <compras-proveedores></compras-proveedores>
</template>

<template v-if="menu==5">
    <ventas-clientes></ventas-clientes>
</template>

<template v-if="menu==6">
    <ventas-ventas></ventas-ventas>
</template>

<template v-if="menu==7">
    <accesso-usuarios></accesso-usuarios>
</template>

<template v-if="menu==8">
    <accesso-roles></accesso-roles>
</template>

<template v-if="menu==9">
    <reportes-ingreso></reportes-ingreso>
</template>

<template v-if="menu==10">
    <reportes-ventas></reportes-ventas>
</template>

<template v-if="menu==11">
    <ayuda></ayuda>
</template>

<template v-if="menu==12">
    <acerca-de></acerca-de>
</template>

@endsection
