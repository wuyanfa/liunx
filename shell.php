Shell

1 . 变量定义

    注意，变量名和等号之间不能有空格，这可能和你熟悉的所有编程语言都不一样。同时，变量名的命名须遵循如下规则：
    1.1 命名只能使用英文字母，数字和下划线，首个字符不能以数字开头。
    1.2 中间不能有空格，可以使用下划线（_）。
    1.3 不能使用标点符号。
    1.4 不能使用bash里的关键字（可用help命令查看保留关键字）。
    your_name="runoob.com"

2, 使用变量
    使用一个定义过的变量，只要在变量名前面加美元符号即可，如：

    your_name="qinjx"
    echo $your_name
    echo ${your_name}

    for skill in Ada Coffe Action Java; do
    echo "I am good at ${skill}Script"
    done

3. 只读变量
    使用 readonly 命令可以将变量定义为只读变量，只读变量的值不能被改变。
    #!/bin/bash
    myUrl="http://www.google.com"
    readonly myUrl
    myUrl="http://www.runoob.com"

4. 删除变量
    使用 unset 命令可以删除变量。语法：
    unset variable_name

5. 变量类型
    运行shell时，会同时存在三种变量：
    1) 局部变量 局部变量在脚本或命令中定义，仅在当前shell实例中有效，其他shell启动的程序不能访问局部变量。
    2) 环境变量 所有的程序，包括shell启动的程序，都能访问环境变量，有些程序需要环境变量来保证其正常运行。必要的时候shell脚本也可以定义环境变量。
    3) shell变量 shell变量是由shell程序设置的特殊变量。shell变量中有一部分是环境变量，有一部分是局部变量，这些变量保证了shell的正常运行

6. Shell 字符串
    1, 单引号
        str='this is a string'
        单引号字符串的限制：

        单引号里的任何字符都会原样输出，单引号字符串中的变量是无效的；
        单引号字串中不能出现单独一个的单引号（对单引号使用转义符后也不行），但可成对出现，作为字符串拼接使用。

    2. 双引号
        your_name='runoob'
        str="Hello, I know you are \"$your_name\"! \n"
        echo $str
        Hello, I know you are "runoob"!

        双引号的优点：
        双引号里可以有变量
        双引号里可以出现转义字符

7. 拼接字符串
        your_name="runoob"
        # 使用双引号拼接
        greeting="hello, "$your_name" !"
        greeting_1="hello, ${your_name} !"
        echo $greeting  $greeting_1
        # 使用单引号拼接
        greeting_2='hello, '$your_name' !'
        greeting_3='hello, ${your_name} !'
        echo $greeting_2  $greeting_3


8. 获取字符串长度
    string="abcd"
    echo ${#string} #输出 4


9. 提取子字符串
    以下实例从字符串第 2 个字符开始截取 4 个字符：

    string="runoob is a great site"
    echo ${string:1:4} # 输出 unoo
10. 查找子字符串
    查找字符 i 或 o 的位置(哪个字母先出现就计算哪个)：

    string="runoob is a great site"
    echo `expr index "$string" io`  # 输出 4

        数组
1， Shell 数组
    bash支持一维数组（不支持多维数组），并且没有限定数组的大小。
    类似与 C 语言，数组元素的下标由 0 开始编号。获取数组中的元素要利用下标，下标可以是整数或算术表达式，其值应大于或等于 0。
    1） 定义数组
        在 Shell 中，用括号来表示数组，数组元素用"空格"符号分割开。定义数组的一般形式为：

        数组名=(值1 值2 ... 值n)
        例如：

        array_name=(value0 value1 value2 value3)

    2）读取数组
        读取数组元素值的一般格式是：

        ${数组名[下标]}
        例如：

        valuen=${array_name[n]}
        使用 @ 符号可以获取数组中的所有元素，例如：

        echo ${array_name[@]}

2 ，获取数组的长度
        获取数组长度的方法与获取字符串长度的方法相同，例如：

        # 取得数组元素的个数
        length=${#array_name[@]}
        # 或者
        length=${#array_name[*]}
        # 取得数组单个元素的长度
        lengthn=${#array_name[n]}

        例如：
        arr_name=($your_name 1 2 3 4)

        echo " arr 个数 ：" ${#arr_name[@]}

        for val in ${arr_name[@]}
        do
        echo $val
        done

        for((i=0;i<${#arr_name[*]};i++));
        do
        echo ${arr_name[$i]}
        done


--------------------------------Shell 传递参数-----------

    我们可以在执行 Shell 脚本时，向脚本传递参数，脚本内获取参数的格式为：$n。n 代表一个数字，1 为执行脚本的第一个参数，2 为执行脚本的第二个参数，以此类推……

    实例
    以下实例我们向脚本传递三个参数，并分别输出，其中 $0 为执行的文件名：

    #!/bin/bash
    # author:菜鸟教程
    # url:www.runoob.com

    echo "Shell 传递参数实例！";
    echo "执行的文件名：$0";
    echo "第一个参数为：$1";
    echo "第二个参数为：$2";
    echo "第三个参数为：$3";

    ./test.sh 1 2 3


    参数处理	说明
    $#	        传递到脚本的参数个数
    $*	        以一个单字符串显示所有向脚本传递的参数。如"$*"用「"」括起来的情况、以"$1 $2 … $n"的形式输出所有参数。
    $$	        脚本运行的当前进程ID号
    $!	        后台运行的最后一个进程的ID号
    $@	        与$*相同，但是使用时加引号，并在引号中返回每个参数。如"$@"用「"」括起来的情况、以"$1" "$2" … "$n" 的形式输出所有参数。
    $-	        显示Shell使用的当前选项，与set命令功能相同。
    $?	        显示最后命令的退出状态。0表示没有错误，其他任何值表明有错误。


    算术运算符
    下表列出了常用的算术运算符，假定变量 a 为 10，变量 b 为 20：

    运算符	                            说明	                                        举例
    +	                                加法	                                        `expr $a + $b` 结果为 30。
    -	                                减法	                                        `expr $a - $b` 结果为 -10。
    *	                                乘法	                                        `expr $a \* $b` 结果为  200。
    /	                                除法	                                        `expr $b / $a` 结果为 2。
    %	                                取余	                                        `expr $b % $a` 结果为 0。
    =	                                赋值	                                        a=$b 将把变量 b 的值赋给 a。
    ==	                                相等                                            用于比较两个数字，相同则返回 true。	[ $a == $b ] 返回 false。
    !=	                                不相等                                          用于比较两个数字，不相同则返回 true。	[ $a != $b ] 返回 true。


    关系运算符
    关系运算符只支持数字，不支持字符串，除非字符串的值是数字。

    下表列出了常用的关系运算符，假定变量 a 为 10，变量 b 为 20：

    运算符	                说明	                                                    举例
    -eq	                    检测两个数是否相等，相等返回 true。	                        [ $a -eq $b ] 返回 false。
    -ne	                    检测两个数是否不相等，不相等返回 true。	                    [ $a -ne $b ] 返回 true。
    -gt	                    检测左边的数是否大于右边的，如果是，则返回 true。	        [ $a -gt $b ] 返回 false。
    -lt	                    检测左边的数是否小于右边的，如果是，则返回 true。	        [ $a -lt $b ] 返回 true。
    -ge	                    检测左边的数是否大于等于右边的，如果是，则返回 true。	    [ $a -ge $b ] 返回 false。
    -le	                    检测左边的数是否小于等于右边的，如果是，则返回 true。	    [ $a -le $b ] 返回 true。


    逻辑运算符
    以下介绍 Shell 的逻辑运算符，假定变量 a 为 10，变量 b 为 20:

    运算符	            说明	                                举例
    &&	                逻辑的 AND	                            [[ $a -lt 100 && $b -gt 100 ]] 返回 false
    ||	                逻辑的 OR	                            [[ $a -lt 100 || $b -gt 100 ]] 返回 true



    字符串运算符
    下表列出了常用的字符串运算符，假定变量 a 为 "abc"，变量 b 为 "efg"：

    运算符	                                说明	                                                            举例
    =	                                    检测两个字符串是否相等，相等返回 true。	                            [ $a = $b ] 返回 false。
    !=	                                    检测两个字符串是否相等，不相等返回 true。	                        [ $a != $b ] 返回 true。
    -z	                                    检测字符串长度是否为0，为0返回 true。	                            [ -z $a ] 返回 false。
    -n	                                    检测字符串长度是否为0，不为0返回 true。	                            [ -n "$a" ] 返回 true。
    str	                                    检测字符串是否为空，不为空返回 true。	                            [ $a ] 返回 true。




    文件测试运算符
    文件测试运算符用于检测 Unix 文件的各种属性。

    属性检测描述如下：

    操作符	                                                    说明	                                                                        举例
    -b file	                                                    检测文件是否是块设备文件，如果是，则返回 true。	                                [ -b $file ] 返回 false。
    -c file	                                                    检测文件是否是字符设备文件，如果是，则返回 true。	                            [ -c $file ] 返回 false。
    -d file	                                                    检测文件是否是目录，如果是，则返回 true。	                                    [ -d $file ] 返回 false。
    -f file	                                                    检测文件是否是普通文件（既不是目录，也不是设备文件），如果是，则返回 true。	    [ -f $file ] 返回 true。
    -g file	                                                    检测文件是否设置了 SGID 位，如果是，则返回 true。	                            [ -g $file ] 返回 false。
    -k file	                                                    检测文件是否设置了粘着位(Sticky Bit)，如果是，则返回 true。	                    [ -k $file ] 返回 false。
    -p file	                                                    检测文件是否是有名管道，如果是，则返回 true。	                                [ -p $file ] 返回 false。
    -u file	                                                    检测文件是否设置了 SUID 位，如果是，则返回 true。	                            [ -u $file ] 返回 false。
    -r file	                                                    检测文件是否可读，如果是，则返回 true。	                                        [ -r $file ] 返回 true。
    -w file	                                                    检测文件是否可写，如果是，则返回 true。	                                        [ -w $file ] 返回 true。
    -x file	                                                    检测文件是否可执行，如果是，则返回 true。	                                    [ -x $file ] 返回 true。
    -s file	                                                    检测文件是否为空（文件大小是否大于0），不为空返回 true。	                    [ -s $file ] 返回 true。
    -e file	                                                    检测文件（包括目录）是否存在，如果是，则返回 true。	                            [ -e $file ] 返回 true。


    %s %c %d %f都是格式替代符

    %-10s 指一个宽度为10个字符（-表示左对齐，没有则表示右对齐），任何字符都会被显示在10个字符宽的字符内，如果不足则自动以空格填充，超过也会将内容全部显示出来。

    %-4.2f 指格式化为小数，其中.2指保留2位小数。

    更多实例：
    printf "%-10s %-8s %-4s\n" 姓名 性别 体重kg
    printf "%-10s %-8s %-4.2f\n" 郭靖 男 66.1234
    printf "%-10s %-8s %-4.2f\n" 杨过 男 48.6543
    printf "%-10s %-8s %-4.2f\n" 郭芙 女 47.9876

    %d %s %c %f 格式替代符详解:

    d: Decimal 十进制整数 -- 对应位置参数必须是十进制整数，否则报错！

    s: String 字符串 -- 对应位置参数必须是字符串或者字符型，否则报错！
    
    c: Char 字符 -- 对应位置参数必须是字符串或者字符型，否则报错！

    f: Float 浮点 -- 对应位置参数必须是数字型，否则报错！