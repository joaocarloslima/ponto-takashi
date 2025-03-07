<x-layout titulo="editar funcionário">
    <x-funcionarios.form 
        :action="route('funcionarios.update', $funcionario->id)" 
        :funcionario="$funcionario" 
        update="true"
    />
</x-layout>